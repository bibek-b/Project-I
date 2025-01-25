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
    $stmt = $connection->prepare('SELECT user_id, username, password, role FROM users WHERE email = ? ');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $hashedPassword, $role);
        $stmt->fetch();

        
        if (password_verify($password, $hashedPassword)) {
            // Set session variables based on role
            if ($role === 'Admin') {
                $_SESSION['Admin'] = [
                    'user_id' => $user_id,
                    'username' => $username,
                    'role' => $role
                ];
                header('Location: ../admin/dashboard.php');
            } else {
                $_SESSION['User'] = [
                    'user_id' => $user_id,
                    'username' => $username,
                    'role' => $role
                ];
                header('Location: ../business/index.php');
            }
            exit();
        } else {
            $error_msg = 'Invalid email or password. Please try again.';
        }
    } else {
        $error_msg = 'Email hasn\'t been registered yet. Please sign up.';
    }
}
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
