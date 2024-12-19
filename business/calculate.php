<?php 
// header('Content-Type: application/json');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


$isLoggedIn = isset($_SESSION['user_id']); // Checks if the user is logged in
$user_id = $isLoggedIn ?$_SESSION['user_id'] : null;

$connection = mysqli_connect('localhost', 'root', 'ngg12#1', 'GlassGuruDB');

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Function to get user details
function getUserDetails($connection, $user_id) {
    $query = 'SELECT * FROM users WHERE user_id = ?';
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result); // Fetch and return user details if exists
    } else {
        return false;
    }
}




// Handles order placement
if (isset($_POST['place_order'])) {
    if ($isLoggedIn) {
        $user_id = $_SESSION['user_id'];
        $userDetails = getUserDetails($connection, $user_id);

        if ($userDetails) {
            // Decode the orders from the request
            $orders = json_decode($_POST['orders'], true);

            // Initialize a flag to track if all orders were successfully inserted
            $allOrdersInserted = true;

            foreach ($orders as $order) {
                $length = $order['length'];
                $breadth = $order['breadth'];
                $unitSel = $order['unitSel'];
                $thicknessSel = $order['thicknessSel'];
                $colorSel = $order['colorSel'];
                $total_sqr_ft = $order['total_sqr_ft'];
                $total_price = $order['total_price'];
                $status='pending';

                // Prepare and execute the SQL insert query
                $query = 'INSERT INTO orders (user_id, username, address, phone, email, length, breadth,total_sqr_ft,total_price,unit,thickness,color,status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?)';
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param(
                    $stmt,
                    'issssssssssss',
                    $user_id,
                    $userDetails['username'],
                    $userDetails['address'],
                    $userDetails['phone'],
                    $userDetails['email'],
                    $length,
                    $breadth,   
                    $total_sqr_ft,
                    $total_price,
                    $unitSel,
                    $thicknessSel,
                    $colorSel,
                    $status
                );

                if (!mysqli_stmt_execute($stmt)) {
                    // If any order insertion fails, set the flag to false
                    $allOrdersInserted = false;
                    break;
                }
            }

            if ($allOrdersInserted) {

                $query = 'select order_id,status from orders where user_id = ? order by order_id desc';
                $stmt = mysqli_prepare($connection,$query);
                mysqli_stmt_bind_param($stmt, 'i',$user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                $orderStatuses = [];
                while($row = mysqli_fetch_assoc($result)) {
                    $orderStatuses[] = [
                        'order_id' => $row['order_id'],
                        'status' => ucfirst($row['status'])
                    ];
                }
                echo json_encode([
                    'success' => true,
                    'alert' => 'Order Successful!',
                    'statusMessage' => 'Your order is processed.', // Success message
                    'orders' => $orderStatuses
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to place the order. Please try again.' // Failure message
                ]);
            }
        } 
    } else {
        echo json_encode([
            'success' => false, 
            'alert' => 'You need to sign up or log in to place an order.',
            'statusMessage' => ''
        ]);
    }
    exit();
}

//loads the order details from the db

if (isset($_GET['fetch_order']) && $isLoggedIn) {

    // Fetch the user's orders from the database
    $query = 'SELECT order_id, status FROM orders WHERE user_id = ? ORDER BY order_id DESC';
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $orderStatuses = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orderStatuses[] = [
            'order_id' => $row['order_id'],
            'status' => ucfirst($row['status']) // Capitalize the status
        ];
    }

    // Respond with JSON
    if (empty($orderStatuses)) {
        echo json_encode([
            'success' => false,
            'orders' => [],
            'message' => 'No orders found.'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'orders' => $orderStatuses
        ]);
    }
    
    exit();
}

// Handle order status update

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['order_id'], $input['status'])) {
        $order_id = intval($input['order_id']);
        $status = in_array($input['status'], ['accepted', 'declined']) ? $input['status'] : 'pending';

        $query = 'UPDATE orders SET status = ? WHERE order_id = ?'; 
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'si', $status, $order_id);

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => "Are you sure? You want to change this Order status  to $status."]);
        } else {
            echo json_encode(['success' => false, 'message' => "Failed to update order status."]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => "Invalid input data."]);
    }
    exit();
}
if (isset($input['order_id'])) {
    $order_id = intval($input['order_id']);
    $query = 'SELECT * FROM orders WHERE order_id = ?';
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'i', $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'data' => $order]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Order not found.']);
    }
    // exit();
}


//show detais
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <link rel="stylesheet" href="assets/css/pages.css"> -->
    <title>Price Calculator</title>
    <style>
        body {
            /* font-family: Arial, sans-serif; */
            padding: 0;
            margin: 0;
            width:100%
        }

        /* Container for overall layout */
        #calc-container{
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* text-align: center; */
            justify-content:space-between;
            position: relative;
        }


        .content-container {
            max-width: 1200px; /* Limit width on large screens */
            min-width: 325px;
            margin: 0 auto; /* Center the content */
            padding: 30px 10px 30px 30px;
            border-radius: 0.3em;
        }
        #section-container{
            background-color: red;
            margin-bottom: 20px
        }
        /* .unit-selector, .thickness-selector, .color-selector,{
            margin-bottom: 5px;
            margin-top: 20px;
            padding: 5px;
            font-size: 16px;
        } */
        #remove-btn{
            margin-bottom: 5px;
            margin-top: 20px;
            padding: 5px;
            font-weight:bold;
            cursor: pointer;
            color: red;
            background: none;
        }

        .unit-selector label {
            margin-right: 20px;
        }

        .unit-selector, .thickness-selector, .color-selector {
            padding: 5px;
            font-size: 16px;
        }

        .input-group {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 0 10px;
            align-items: center;
            margin-bottom: 0px;
        }

        .input-group input  {
            padding: 8px;
            min-width: 0;
            width: 100%;
            box-sizing: border-box;
        }

        .input-group .remove-btn {
            background-color: transparent;
            border: none;
            font-size: 30px;
            cursor: pointer;
            color: #ff4d4d;
            padding: 5px;
        }

        .input-group .remove-btn:hover {
            color: #e60000;
        }

        .result-display {
            font-weight: bold;
            color: #333;
            white-space: nowrap; /* Prevent the text from wrapping */
        }

        .total-result {
            margin-top: 20px;
            font-size: 18px;
        }

        .add-box-btn {
            background-color: #4CAF50; /* Green color for the add button */
            border-radius: 0.3em;
            width: 40px;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .add-box-btn:hover {
            background-color: #45a049; /* Darker green on hover */

        }

        #calculate-total-btn, #new-section-btn {
            margin-left: 10px;
            margin-top:10px;
            padding: 10px;
            cursor: pointer;
            /* border-radius: 0.3em; */
            font-size: 16px;
        }
       
        .remove-btn {
            margin-left: 10px;
            cursor: pointer;
            color: red;
            font-weight: bold;
        }
        .result-display {
            margin-top: 0px;
            
        }
        #result{
            margin-top: 10px;
            
        }
        #order-status{
            position: absolute;
            right: 150px;
            top: 150px;
            border: 1px solid black;
            padding: 20px;
            border-radius:7px;
            /* width: 200px; */
        }
        #order-status p{
            margin-top: 7px;
        }
        #order-status h4{
            border-bottom: 1px solid black;
        }
        

        /* Responsive Design for Mobile */
        @media only screen and (max-width: 600px) {
        .input-group {
            grid-template-columns: 1fr 1fr auto; /* Still maintain 2 columns for inputs and 1 auto-sized for button */
            }
            .result-display {
                grid-column: span 3; /* Result will take up the full width on small screens */
            }
         }
         
    </style>
</head>
<body>
    <div id="calc-container" data-loggged-in="<?php echo $isLoggedIn ? 'true' : 'false'; ?>">
        <?php include 'includes/navbar.php'; ?>

        <div class="content-container">
            <h1>Price Calculator</h1>
            <div id="sections-container"></div>
            <button id="new-section-btn" >New Section</button>
            <button id="calculate-total-btn" >Calculate Total</button>&nbsp;&nbsp;
            <button id="place-order-btn" name="place_order" style="display: none;">Place Order</button>
            <div id="result"></div>

            <div id="statusMessage" style="font-size:1.2rem; margin-top: 1rem;"></div>
        </div>
        <div id="order-status" style="display:<?php echo $isLoggedIn ? 'block' : 'none'; ?>">
            <h4>Order Status</h4>
          <div id="order-status-content">

          </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>


    <script src="assets/js/calculate.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>

