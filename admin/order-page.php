<?php
// Database Connection
$conn = mysqli_connect('localhost', 'root', 'ngg12#1', 'GlassGuruDB');

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Fetch all orders
$query = 'SELECT * FROM orders';
$result = mysqli_query($conn, $query);
$orders = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
}

// Fetch order details grouped by order_id
$detailsQuery = 'SELECT * FROM orders'; // Replace with your correct table name for order details
$detailsResult = mysqli_query($conn, $detailsQuery);
$orderDetails = [];

if ($detailsResult) {
    while ($row = mysqli_fetch_assoc($detailsResult)) {
        $orderDetails[$row['order_id']][] = [
            'thickness' => $row['thickness'],
            'color' => $row['color'],
            'length' => $row['length'],
            'breadth' => $row['breadth']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <link rel="stylesheet" href="assets/css/order-page.css">
    <title>Order Receive</title>
    <style>
        /* Modal Styling */
        #details-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            z-index: 1000;
        }

        .modal-content {
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            color: #333;
        }

        .detail-row {
            margin-bottom: 15px;
        }
        
        .show-details{
            background-color: rgba(0, 0, 0, 0.3);
        }

    </style>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div id="wrapper">
        <div class="container">
            <h1 style="margin-top: 1rem;">Manage Order</h1>

            <!-- Order Summary Table -->
            <table class="order-receive">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Total Square Footage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="order-summary">
                    <?php
                    $sn = 1;
                    foreach ($orders as $order) {
                        $totalSquareFootage = $order['length'] * $order['breadth'] / 144; // in inches
                        $status = ucfirst($order['status']);
                        echo "<tr>
                            <td>{$sn}</td>
                            <td>{$order['username']}</td>
                            <td>{$order['address']}</td>
                            <td>{$order['phone']}</td>
                            <td>{$order['email']}</td>
                            <td>" . number_format($totalSquareFootage, 2) . " sq. ft.</td>
                            <td class='order-actions'>";


                        if ($status === 'Pending') {
                            echo "<button class='btn btn-accept' onclick='updateOrderStatus({$order['order_id']}, \"accepted\")'>Accept</button>
        <button class='btn btn-decline' onclick='updateOrderStatus({$order['order_id']}, \"declined\")'>Decline</button>
          <button class='btn show-details' onclick='showDetails({$order['order_id']})'>Details</button>
    ";
                        } else {
                            echo "<span>{$status}</span>
         <td class='order-actions'>
                                <button class='btn show-details' onclick='showDetails({$order['order_id']})'>Details</button>
                            </td>";
                        }

                        // </tr>";
                        $sn++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Order Details -->
    <div id="details-container">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">X</span>
            <h2 style="text-decoration: underline;">Order Details</h2>
            <br>
            <div id="glass-details"></div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        async function updateOrderStatus(order_id, status) {
            console.log("Fetching order details...");
            console.log("Order ID:", order_id);
            const response = await fetch("../business/calculate.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    order_id: order_id,
                    status: status
                })

            });
            const data = await response.json();

            if (data.success === true) {


                alert(data.message);
            } else {
                alert(data.message);
            }
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        }


        // Preload order details
        const orderDetails = <?php echo json_encode($orderDetails); ?>;
        console.log("Order Details:", orderDetails);

        // Show glass order details
        function showDetails(order_id) {
            const detailsContainer = document.getElementById("details-container");
            const glassDetails = document.getElementById("glass-details");

            // Clear previous details
            glassDetails.innerHTML = "";

            if (orderDetails[order_id]) {
                console.log(orderDetails[order_id]);
                orderDetails[order_id].forEach((item, index) => {
                    const row = document.createElement("div");
                    row.className = "detail-row";
                    row.innerHTML = `
                        <p><strong>Item ${index + 1}:</strong></p>
                        <br>
                        <p>Thickness: ${item.thickness}</p>
                        <br>
                        <p>Color: ${item.color}</p>
                        <br>
                        <p>Length: ${item.length}</p>
                        <br>
                        <p>Breadth: ${item.breadth}</p>
                        <br>
                        <p>Square Footage: ${((item.length * item.breadth) / 144).toFixed(2)} sq. ft.</p>
                        <hr>
                    `;
                    glassDetails.appendChild(row);
                });

                detailsContainer.style.display = "block";
            } else {
                alert("No details found for this order.");
            }
        }

        // Close Modal
        function closeModal() {
            document.getElementById("details-container").style.display = "none";
        }
    </script>
</body>

</html>