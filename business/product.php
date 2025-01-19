<?php

session_start();
error_reporting(E_ALL);
include 'includes/navbar.php';

$conn = mysqli_connect('localhost', 'root', 'ngg12#1', 'GlassGuruDB');

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Get the product ID from the URL
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

// Fetch product details
$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$product_result = $stmt->get_result();

if ($product_result && $product_result->num_rows > 0) {
    $product = $product_result->fetch_assoc();
} else {
    die('Product not found!');
}


// Handle Order Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_btn'])) {
    if ($user_id > 0) {
        // Retrieve user details
        $user_query = "SELECT username, address, phone, email FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($user_query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $user_result = $stmt->get_result();

        if ($user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();

            // Calculate order details
            $length = $product['length'];
            $breadth = $product['breadth'];
            $total_sqr_ft = round(($length * $breadth) / 144, 2);
            $total_price = $total_sqr_ft * $product['price'];

            // Check if the order already exists
            $order_check_query = "SELECT * FROM orders WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($order_check_query);
            $stmt->bind_param('ii', $user_id, $product_id);
            $stmt->execute();
            $order_check_result = $stmt->get_result();

            if ($order_check_result->num_rows > 0) {
                echo "<script>
                 setTimeout(() => {
                 alert('You have already placed an order for this product.');
            },1000)
            </script>";
        
            } else {
                // Insert the order into the database
                $insert_order_query = "
                INSERT INTO orders 
                (user_id, username, address, phone, email, product_id, product_title, length, breadth, total_sqr_ft, total_price, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

                $stmt = $conn->prepare($insert_order_query);
                $stmt->bind_param(
                    'issssisssdd',
                    $user_id,
                    $user['username'],
                    $user['address'],
                    $user['phone'],
                    $user['email'],
                    $product_id,
                    $product['title'],
                    $length,
                    $breadth,
                    $total_sqr_ft,
                    $total_price
                );

                if ($stmt->execute()) {
                    echo "<script>
                    const userChoice = confirm('Are You Sure? You Want To Place Order!');
                     if(userChoice){
                       setTimeout(() => {
                              alert('Order Placed Successfully!');
                                window.location.reload();
                           }, 1000);
                       }
                </script>";
                } else {
                    echo "<script>alert('Failed to place order: " . $stmt->error . "');</script>";
                }
            }
        } else {
            echo "<script>alert('User details not found.');</script>";
        }
    } else {
        echo "<script>alert('Please log in to place an order.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['title']; ?> - Product Details</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/pages.css">
</head>
<body>
    <div class="wrapper">

        <div class="product-details-container">
            <div class="product-image">
                <img src="../admin/uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>">
            </div>
            <div class="product-info">
                <h1><?php echo $product['title']; ?></h1>
                <p>Length: <?php echo $product['length'] ?> mm</p>
                <p>Breadth: <?php echo $product['breadth'] ?> mm</p>
                <p style='color: orangered;'><strong>Price:</strong> Rs. <?php echo $product['price']; ?></p>
                <p><?php echo $product['description']; ?></p>
                <div class="btns">
                    <form action="" method="post"  onsubmit="return disableButtonOnSubmit(this);">
                    <button class="btn order-btn" name="order_btn">Order Now</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    </form>
               
                <form method="post" action="cart_details.php">
                <input type="hidden" name="product_id" value='<?php echo $product_id?>'>
                <input type="hidden" name="user_id" value='<?php echo $user_id ?>'>
                <button type="submit" class="btn add-to-cart-btn">Add to cart</button>
                </form>
                </div>
            </div>
        </div>
        

    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
</body>
</html>