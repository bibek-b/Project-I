<?php
// Start session
session_start();

$connection = mysqli_connect('localhost', 'root', '', 'GlassGuruDB');

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Initialize variable for error message
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data, ensuring they are set
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Check if the email exists in the users table
    $stmt = $connection->prepare('SELECT user_id, username FROM users WHERE email = ? AND password = ?');
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username);
        $stmt->fetch();

        // Set session variables for the logged-in user
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;

        // Redirect to the home page
        header('Location: index.php');
        exit;
    }
    $stmt->close();

    // Check if the email exists in the admin table
    $stmt = $connection->prepare('SELECT id, username, password, role FROM admin WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id, $admin_username, $admin_password, $admin_role);
        $stmt->fetch();

            // Set session variables for the logged-in admin
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['username'] = $admin_username;
            $_SESSION['role'] = $admin_role;

            // Redirect to admin dashboard
            header('Location: ../admin/dashboard.php');
            exit;
          
            
        
    } else {
        $error_msg = 'Incorrect email or password. Please try again.';
    }
    $error_msg ='';
    $stmt->close();
}
session_destroy();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login</title>
</head>
<body>
    <div id="container">
        <?php include 'includes/navbar.php'; ?>
        <section class="login-section">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <?php if(!empty($error_msg)): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($error_msg); ?></p>
                    <?php endif; ?>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Enter Your Email">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required placeholder="Enter Your Password">
                </div>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
        </section>
        <?php include 'includes/footer.php'; ?>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>