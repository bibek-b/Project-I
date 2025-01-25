
<?php

$conn = mysqli_connect('localhost', 'root', '', 'GlassGuruDB');

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

session_start();
$isLoggedIn = isset($_SESSION['User']);
$user_id = $isLoggedIn ? $_SESSION['User']['user_id'] : null;

$orderStatuses = [];

// Fetch orders for the logged-in user
if ($isLoggedIn) {
    $query = 'SELECT order_id, status FROM orders WHERE user_id = ? ORDER BY order_id DESC';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $orderStatuses[] = [
            'order_id' => $row['order_id'],
            'status' => ucfirst($row['status']) // Capitalize the status
        ];
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/order-details.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div id="order-container">
    
    <section class="order-details">
    <h2>Your Order Details</h2>
        <?php if ($isLoggedIn): ?>
            <?php if (!empty($orderStatuses)): ?>
                <?php foreach ($orderStatuses as $order): ?>
                    <div class="order-item">
                        <h3>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h3>
                        <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
                        <br>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p id="nof">No orders found.</p>
            <?php endif; ?>
        <?php else: ?>
            <p id="lg">Please <a href="login.php" >Login here</a> to view your orders.</p>
        <?php endif; ?>
    </section>
    
</div>
<br>
<?php include 'includes/footer.php'; ?>
</body>
</html>



