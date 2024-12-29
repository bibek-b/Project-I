<!-- includes/navbar.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
        /* Space between user icon and logout button */
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
    .carts{
    padding: 10px;
    position: absolute;
    right: 140px;
    cursor: pointer;
}
#cart{
    width: 30px;
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
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="calculate.php">Calculate</a></li>
        </ul>
        <div class="carts" onclick="MoveToCart()">
            <img src="./assets/images/carts.png"  id="cart"/>
            <h3>Cart</h3>
            </div>
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['username'])): ?>
            <div class="user-info">
                <div class="icon-section">
                    <img src="assets/images/user-icon1.png" alt="User Icon" class="user-icon">
                    <form action="./login.php" method="post" style="display: inline;" class="logout-form">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
                <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>    
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
    function MoveToCart(){
        setTimeout(() => {
            window.location.href = 'cart_details.php';
        }, 1000);
    }

</script>