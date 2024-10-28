<!-- includes/navbar.php -->
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

        <div class="auth-links">
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        </div>
    </div>
</nav>
