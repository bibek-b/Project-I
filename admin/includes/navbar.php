<!-- includes/navbar.php -->


<?php
session_start();

$conn = mysqli_connect('localhost', 'root', 'ngg12#1', 'GlassGuruDB');

if (!$conn) {
    die('connection failed' . mysqli_connect_error());
}


$adminImage = 'assets/images/admin-icon.png';

if (isset($_SESSION['admin_id'])) {
    $adminId = $_SESSION['admin_id'];
    $result = mysqli_query($conn, "SELECT * FROM admin WHERE id = '$adminId'");
    if ($result && mysqli_num_rows($result) > 0) {
        $adminData = mysqli_fetch_assoc($result); 
    }
}

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
            <li><a href="dashboard.php" class="nav-link" data-target="dashboard.php">Dashboard</a></li>
            <li><a href="manage-products.php" class="nav-link" data-target="manage-products.php">Manage Products</a></li>
            <li><a href="manage-users.php" class="nav-link" data-target="manage-users.php">Manage Users</a></li>
            <li><a href="manage-calculator.php" class="nav-link" data-target="manage-calculator.php">Manage Calculator</a></li>
            <li><a href="order-page.php" class="nav-link" data-target="order-page.php">Manage Order</a></li>
        </ul>

        <div class="auth-links">
            <?php if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])): ?>
                <div class="admin-info">
                    <img src="<?php echo htmlspecialchars($adminImage); ?>" alt="Admin Icon" class="admin-icon">
                    <span class="admin-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>

                </div>
                    <button onclick="window.location.href = '../business/login.php'" class="logout-btn">Logout</button>
                </form>
        </div>
    <?php endif; ?>
    </div>
</nav>
<script>
    function toggleMenu() {
        const navLinks = document.querySelector('.nav-links');
        navLinks.classList.toggle('show');
    }
</script>
<script src="assets/js/admin-script.js"></script>