
<?php

// Dummy data (replace with actual database queries in a real setup)
$totalProducts = 100; // Replace with query to count products
$totalUsers = 50;     // Replace with query to count users
$totalCalculatorUses = 30; // Replace with query to track calculator usage
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

        <div class="admin-content">
            <h2>Welcome to the Admin Dashboard</h2>
            
            <!-- Overview Section -->
            <div class="overview">
                <div class="overview-card">
                    <h4>Total Products</h4>
                    <p><?php echo $totalProducts; ?></p>
                </div>
                <div class="overview-card">
                    <h4>Total Users</h>
                    <p><?php echo $totalUsers; ?></p>
                </div>
                <div class="overview-card">
                    <h4>Calculator Usage</h4>
                    <p><?php echo $totalCalculatorUses; ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</div>



<script src="assets/js/admin-script.js"></script>
</body>
</html>
