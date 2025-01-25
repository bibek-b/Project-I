<!-- includes/navbar.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the current page name to determine the active link
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
    .user-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .icon-section {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .user-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
    }

    .username {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        text-align: center;
        margin-left: -70px;
        font-size: 1.3rem;
        text-transform: capitalize;
    }

    .logout-form {
        margin: 0;
    }

    .logout-btn {
        border: none;
        background-color: #f00;
        color: #fff;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
        background-color: #c00;
    }

    .carts {
        padding: 10px;
        position: absolute;
        right: 140px;
        cursor: pointer;
    }

    #cart {
        width: 30px;
    }

    .nav-links li a {
        text-decoration: none;
        color: #fff;
        padding: 10px 15px;
        transition: background-color 0.3s ease;
        border-radius: 4px;
    }

    .nav-links li a.active {
        background-color: #22D3EE; /* Highlight color for active link */
        color: white;
        font-weight: bold;
    }

    .nav-links li a:hover {
        background-color: #22D3EE;
    }
</style>

<nav class="navbar">
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <img src="assets/images/white-logo.png" alt="Logo">
            </a>
        </div>

        <!-- Hamburger icon for smaller screens -->
        <div class="menu-icon" onclick="toggleMenu()">
            ☰
        </div>

        <ul class="nav-links" id="navLinks">
            <li><a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a></li>
            <li><a href="services.php" class="<?php echo $current_page == 'services.php' ? 'active' : ''; ?>">Services</a></li>
            <li><a href="products.php" class="<?php echo $current_page == 'products.php' ? 'active' : ''; ?>">Products</a></li>
            <li><a href="about.php" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a></li>
            <li><a href="calculate.php" class="<?php echo $current_page == 'calculate.php' ? 'active' : ''; ?>">Calculate</a></li>
            <li><a href="order_details.php" class="<?php echo $current_page == 'order_details.php' ? 'active' : ''; ?>">Order Details</a></li>
        </ul>

        <div class="carts" onclick="MoveToCart()">
            <img src="./assets/images/carts.png" id="cart" />
            <h3>Cart</h3>
        </div>

        <?php if (isset($_SESSION['User'])): ?>
            <div class="user-info">
                <div class="icon-section">
                    <img src="assets/images/user-icon1.png" alt="User Icon" class="user-icon">
                    <form action="/Project-I/admin/logout.php" method="post" style="display: inline;" class="logout-form">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
                <span class="username"><?php echo htmlspecialchars($_SESSION['User']['username']); ?></span>    
            </div>
        <?php else: ?>
            <div class="auth-links">
                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<script>
    function MoveToCart() {
        setTimeout(() => {
            window.location.href = 'cart_details.php';
        }, 1000);
    }
</script>
