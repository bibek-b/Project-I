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

        <?php
        //signup
        //connection
        $connection = mysqli_connect('localhost', 'root', 'ngg12#1', 'GlassGuruDB');

        if (!$connection) {
            die('connection failed' . mysqli_connect_error());
        
        }
        $signupSucess = false;
        $email_error_msg = '';

        //checks is form is submitted 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //get form data
            $userName = $_POST['userName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_Password = $_POST['confirm_Password'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            //check if email is already exists
            $stmt = $connection->prepare('SELECT email from users where email = ?');
            $stmt-> bind_param('s', $email);
            $stmt-> execute();
            $stmt->store_result();

            if($stmt->num_rows > 0) {
                //Email already exists
                $email_error_msg = 'This email is already registered. please use a different email.';
                
            } else {
                //insert new user if email doesn't exist
                $stmt->close();
                $stmt = $connection->prepare('insert into users(userName,email,password,confirm_Password,phone,address)
                    values(?,?,?,?,?,?)');
                $stmt->bind_param('ssssss', $userName, $email, $password, $confirm_Password,$phone,$address);
                $stmt->execute();
                $signupSucess = true;
            }
                $stmt->close();
            }
             
        //close the db connection
        $connection->close();
        ?>

        <section class="signup-section">
            <?php if ($signupSucess): ?>
                <h2>Welcome to GlassGuru,<?php echo htmlspecialchars($userName); ?>!</h2>
                <p>Your account has been successfully created.<br>
                    Now you can <a href="login.php"> Login here.</a> <br>To access your dashboard and start exploring our products.</p>
            <?php else: ?>
                <h2>Sign Up</h2>
                <?php if(!empty($email_error_msg)) :?>
                    
                    <p style="color: red;"><?php
                        $signupSucess = false;
                         echo $email_error_msg; ?></p>
                    <?php endif; ?>
                <form action="" method="post" onsubmit="validateSignup(event)">
                    <div class="form-group">
                        <label for="userName">Username:</label>
                        <input type="text" id="username" name="userName" required placeholder="Enter Your Username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required placeholder="Enter Your Email">
                        <p id="email-error-msg"></p>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required placeholder="Enter Your Password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_Password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_Password" required placeholder="Confirm Your Password">
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" required placeholder="Enter Your Address">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone No:</label>
                        <input type="int" maxlength="10" id="phone" name="phone" required placeholder="+977-XXXXXXXXXX">
                    </div>
                    <p id='error-msg'></p>
                    <button type="submit">Sign Up</button>
                </form>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            <?php endif; ?>
        </section>

        <?php include 'includes/footer.php'; ?>
    </div>
    <script src="assets/js/script.js"></script>

</body>
</html>