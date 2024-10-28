<!-- login.php -->
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
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
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
