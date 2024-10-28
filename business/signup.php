<!-- signup.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Sign Up</title>
</head>
<body>
    <div id="container">
        <?php include 'includes/navbar.php'; ?>

        <section class="signup-section">
            <h2>Sign Up</h2>
            <form action="signup.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </section>

        <?php include 'includes/footer.php'; ?>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
