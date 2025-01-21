
<?php

$conn = mysqli_connect('localhost','root','ngg12#1','GlassGuruDB');

if(!$conn){
    die('Database connection failed: ' .mysqli_connect_error());
}

    //1.fetchs total products
    $productQuery = 'select count(*) as total_products from products';
    $productResult = mysqli_query($conn,$productQuery);
    $productData = mysqli_fetch_assoc($productResult);
    $totalProducts = $productData['total_products'];
    //2.fetch total users
    $userQuery = 'select count(*) as total_users from users';
    $userResult = mysqli_query($conn,$userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    $totalUsers = $userData['total_users'];


    $orderQuery = 'select count(*) as total_orders from orders';
    $OrderResult = mysqli_query($conn,$orderQuery);
    $orderData = mysqli_fetch_assoc($OrderResult);
    $totalOrders = $orderData['total_orders'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <link rel="stylesheet" href="assets/css/product.css">
</head>
<body>

<div id="container">
    <?php include 'includes/navbar.php';?>

    <div class="admin-layout">

        <div id="" class="admin-content">
            <h2>Welcome to the Admin Dashboard</h2>
            
            <!-- Overview Section -->
            <div class="overview">
                <div class="overview-card">
                    <h4>Total Products</h4>
                    <p><?php echo $totalProducts; ?></p>
                </div>
                <div class="overview-card">
                    <h4>Total Users</h4>
                    <p><?php echo $totalUsers; ?></p>
                </div>
                <div class="overview-card">
                    <h4>Total Orders</h4>
                    <p><?php echo $totalOrders; ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</div>



<script src="assets/js/admin-script.js"></script>
</body>
</html>