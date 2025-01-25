<!-- includes/navbar.php -->

<?php
$conn = mysqli_connect('localhost', 'root', '', 'GlassGuruDB');

if (!$conn) {
    die('connection failed' . mysqli_connect_error());
}

$adminImage = 'assets/images/admin-icon.png';

if (isset($_SESSION['Admin'])) {
    $adminId = $_SESSION['Admin']['user_id'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$adminId'");
    if ($result && mysqli_num_rows($result) > 0) {
        $adminData = mysqli_fetch_assoc($result); 
    }
}
// Get the current page name to determine the active link
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
    .auth-links {
        gap: 8px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .admin-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .admin-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .admin-name {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        text-align: center;
        font-size: 1.1rem;
        text-transform: capitalize;
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

    .login-btn {
        font-size: 14px;
        color: #fff;
        text-decoration: none;
        padding: 5px 10px;
        border: 1px solid #fff;
        border-radius: 5px;
    }

    .login-btn:hover {
        background-color: #fff;
        color: #000;
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
            <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
            <li><a href="manage-products.php" class="<?php echo $current_page == 'manage-products.php' ? 'active' : ''; ?>">Manage Products</a></li>
            <li><a href="manage-users.php" class="<?php echo $current_page == 'manage-users.php' ? 'active' : ''; ?>">Manage Users</a></li>
            <li><a href="order-page.php" class="<?php echo $current_page == 'order-page.php' ? 'active' : ''; ?>">Manage Order</a></li>
        </ul>

        <div class="auth-links">
            <?php if (isset($_SESSION['Admin'])): ?>
                <div class="admin-info">
                    <img src="<?php echo htmlspecialchars($adminImage); ?>" alt="Admin Icon" class="admin-icon">
                    <span class="admin-name"><?php echo htmlspecialchars($_SESSION['Admin']['username']); ?></span>
                </div>
                <button onclick="window.location.href = '/Project-I/admin/logout.php'" class="logout-btn">Logout</button>
            <?php endif; ?>
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
