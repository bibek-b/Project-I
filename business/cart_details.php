<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$conn = mysqli_connect('localhost', 'root', 'ngg12#1', 'GlassGuruDB');

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
        }  // Get product length and breadth
        $product_query = "SELECT length, breadth FROM products WHERE product_id = $product_id";
        $product_result = mysqli_query($conn, $product_query);
        if ($product_row = mysqli_fetch_assoc($product_result)) {
            $length = $product_row['length'];
            $breadth = $product_row['breadth'];

            // Insert into the cart
            $insert_query = "INSERT INTO cart (user_id, product_id, length, breadth, quantity) VALUES (?, ?, ?, ?, 1)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param('iiss', $user_id, $product_id, $length, $breadth);
            if ($stmt->execute()) {
                $message = "Product added to the cart.";
            } else {
                $message = "Failed to add product to cart: " . mysqli_error($conn);
            }
            $stmt->close();
        } else {
            $message = "Product not found.";
        }
    }
} else {
    $message = "Invalid user or product ID.";
}

// Fetch cart items for the logged-in user
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
    $cart_query = "
        SELECT c.cart_id, p.title,p.length,p.breadth, p.price, p.image, c.quantity
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order_btn'])) {
    $cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;

    if ($cart_id > 0) {
        // Retrieve user details
        $user_query = "SELECT username, address, phone, email FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($user_query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $user_result = $stmt->get_result();

        if ($user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();

            // Retrieve cart details
            $cart_query = "
                SELECT c.length, c.breadth, c.quantity, p.price, 
                       ROUND((c.length * c.breadth)/144, 2) AS total_sqr_ft, 
                       (c.quantity * p.price) AS total_price 
                FROM cart c
                JOIN products p ON c.product_id = p.product_id
                WHERE c.cart_id = ?";
            $stmt = $conn->prepare($cart_query);
            $stmt->bind_param('i', $cart_id);
            $stmt->execute();
            $cart_result = $stmt->get_result();

            if ($cart_result->num_rows > 0) {
                $cart_row = $cart_result->fetch_assoc();
                $length = $cart_row['length'];
                $breadth = $cart_row['breadth'];
                $total_sqr_ft = $cart_row['total_sqr_ft'];
                $total_price = $cart_row['total_price'];

                $insert_order_query = "
                    INSERT INTO orders 
                    (user_id, username, address, phone, email, length, breadth, total_sqr_ft, total_price, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
                $stmt = $conn->prepare($insert_order_query);
                $stmt->bind_param(
                    'isssssdds',
                    $user_id,
                    $user['username'],
                    $user['address'],
                    $user['phone'],
                    $user['email'],
                    $length,
                    $breadth,
                    $total_sqr_ft,
                    $total_price
                );

                if ($stmt->execute()) {
                        // Optionally clear the cart after placing the order
                        $clear_cart_query = "DELETE FROM cart WHERE cart_id = ?";
                        $stmt = $conn->prepare($clear_cart_query);
                        $stmt->bind_param('i', $cart_id);
                        $stmt->execute();
                } else {
                    echo "Failed to place order: " . $stmt->error;
                }
            } else {
                echo "Cart details not found for cart ID: " . $cart_id;
            }
        } else {
            echo "User details not found.";
        }
    } else {
        echo "Invalid cart ID.";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_all_order_btn'])) {
    if ($isLoggedIn) {
        $user_id = $_SESSION['user_id'];

        // Retrieve user details
        $user_query = "SELECT username, address, phone, email FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($user_query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $user_result = $stmt->get_result();

        if ($user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();

            // Retrieve cart details
            $cart_query = "
                SELECT c.length, c.breadth, c.quantity, p.price, 
                       ROUND((c.length * c.breadth)/144, 2) AS total_sqr_ft, 
                       (c.quantity * p.price) AS total_price 
                FROM cart c
                JOIN products p ON c.product_id = p.product_id
                WHERE c.user_id = ?";
            $stmt = $conn->prepare($cart_query);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $cart_result = $stmt->get_result();

            // Insert each cart item as an order
            $allOrdersInserted = true;
            while ($cart_row = $cart_result->fetch_assoc()) {
                $length = $cart_row['length'];
                $breadth = $cart_row['breadth'];
                $quantity = $cart_row['quantity'];
                $total_sqr_ft = $cart_row['total_sqr_ft'];
                $total_price = $cart_row['total_price'];

                $insert_order_query = "
                    INSERT INTO orders 
                    (user_id, username, address, phone, email, length, breadth, total_sqr_ft, total_price, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
                $stmt = $conn->prepare($insert_order_query);
                $stmt->bind_param(
                    'isssssdds',
                    $user_id,
                    $user['username'],
                    $user['address'],
                    $user['phone'],
                    $user['email'],
                    $length,
                    $breadth,
                    $total_sqr_ft,
                    $total_price
                );

                if (!$stmt->execute()) {
                    $allOrdersInserted = false;
                    break;
                }
            }

            if ($allOrdersInserted) {
                // Optionally clear the cart after placing the order
                $clear_cart_query = "DELETE FROM cart WHERE user_id = ?";
                $stmt = $conn->prepare($clear_cart_query);
                $stmt->bind_param('i', $user_id);
                $stmt->execute();

                $message = "Order placed successfully!";
            } else {
                $message = "Failed to place the order.";
            }
        } else {
            $message = "User details not found.";
        }
    } else {
        $message = "You must be logged in to place an order.";
    }
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
                            <p>Length: <?php echo $row['length']; ?><br></p>
                            <p>Breadth: <?php echo $row['length']; ?><br></p>
                            <p>PRICE: Rs. <?php echo number_format($row['price'], 2); ?><br></p>
                            <p>QUANTITY: <?php echo $row['quantity']; ?><br></p>
                            <p>SUB-TOTAL: Rs. <?php echo number_format($subtotal, 2); ?></p><br>
                            <form method="post" action="cart_details.php">
                                <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>"> 
                                    <button type="submit" class="remove-btn" name="remove_btn">Remove</button>&nbsp;
                                    <button type="submit" class="order-btn" name="place_order_btn">Place Order</button>
                            </form>

                        </div>
                    </div>
                <?php endwhile; ?>
                <form method="post" action="cart_details.php">
                <div class="total-details">
                <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                    <h3>Total: Rs. <?php echo number_format($total_price, 2); ?></h3>
                    <button class="place-all-order-btn" name="place_all_order_btn">Place all Order</button>
                </div>
                </form>
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