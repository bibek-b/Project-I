<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'GlassGuruDB');

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

$isLoggedIn = isset($_SESSION['user_id']);
$total_price = 0;


// Handle adding products to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

    if ($user_id > 0 && $product_id > 0) {
        // Check if the product is already in the cart
        $check_query = "SELECT * FROM cart WHERE product_id = $product_id AND user_id = $user_id";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // If product exists, update quantity
            $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE product_id = $product_id AND user_id = $user_id";
            if (mysqli_query($conn, $update_query)) {
                $message = "Product quantity updated in the cart.";
            } else {
                $message = "Failed to update cart.";
            }
        } else {
            // If product does not exist, insert it into the cart
            $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
            if (mysqli_query($conn, $insert_query)) {
                $message = "Product added to the cart.";
            } else {
                $message = "Failed to add product to cart.";
            }
        }
    } else {
        $message = "Invalid user or product ID.";
    }
}

// Fetch cart items for the logged-in user
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
    $cart_query = "
        SELECT c.cart_id, p.title, p.price, p.image, c.quantity
        FROM cart c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = $user_id
    ";
    $cart_result = mysqli_query($conn, $cart_query);
} else {
    $cart_result = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_btn'])) {
    $cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;

    if (!empty($cart_id)) {
        $stmt = $conn->prepare('DELETE FROM cart WHERE cart_id = ?');
        $stmt->bind_param('i', $cart_id);
        $stmt->execute();
        $stmt->close();
        echo 'Product removed from cart';
    } else {
        echo 'Invalid cart id';
    }
    exit(); // Stop further processing
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/pages.css">
    <link rel="stylesheet" href="assets/css/cart-details.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="wrapper">
        <h1>Your Cart Details</h1>
        <div class="cart-container">
            <?php if ($cart_result && mysqli_num_rows($cart_result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($cart_result)): 
                            $subtotal = $row['price'] * $row['quantity'];
                            $total_price += $subtotal;
                        ?>
                                <div class="cart-details">
                                <img src="../admin/uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" class="cart-image">
                               <div class="cart-info">
                                <h2>Product Details</h2>
                                <p>TITLE: <?php echo $row['title']; ?><br></p>
                                <p>PRICE: Rs. <?php echo number_format($row['price'], 2); ?><br></p>
                               <p>QUANTITY: <?php echo $row['quantity']; ?><br></p>
                                <p>SUB-TOTAL: Rs. <?php echo number_format($subtotal, 2); ?></p><br>
                                <form method="post" action="cart_details.php" >
                                    <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                                    
                                    <button type="submit" class="remove-btn" name="remove_btn">Remove</button>&nbsp;
                                    <button type="submit" class="order-btn" name="place_order_btn">Place Order</button>
                                    </form>
                                
                               </div>
                                </div>
                        <?php endwhile; ?>
               <div class="total-details">
                <h3>Total: Rs. <?php echo number_format($total_price, 2); ?></h3>
                <button class="place-all-order-btn">Place all Order</button>
                </div>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
       
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
<script src="./assets/js/script.js"></script>
<?php
// Close the database connection
mysqli_close($conn);
?>