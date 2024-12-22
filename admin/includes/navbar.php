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
            <li><a href="dashboard.php"  class="nav-link" data-target = "dashboard.php" >Dashboard</a></li>
            <li><a href="manage-products.php"  class="nav-link" data-target ="manage-products.php" >Manage Products</a></li>
            <li><a href="manage-users.php"  class="nav-link" data-target = "manage-users.php" >Manage Users</a></li>
            <li><a href="manage-calculator.php"  class="nav-link" data-target ="manage-calculator.php">Manage Calculator</a></li>
            <li><a href="order-page.php"  class="nav-link" data-target ="order-page.php">Manage Order</a></li>
        </ul>

        <div class="auth-links">
            <a href="/Project-I/business/index.php">Log-out</a>
        </div>
    </div>
</nav>
<script>
    function toggleMenu() {
        const navLinks = document.querySelector('.nav-links');
        navLinks.classList.toggle('show');
    }
</script>
<script src="assets/js/admin-script.js"></script>
