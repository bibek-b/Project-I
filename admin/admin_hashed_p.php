<?php
// Connect to the database
$connection = mysqli_connect('localhost', 'root', 'ngg12#1', 'GlassGuruDB');

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Admins and their new passwords
$admins = [
    'bibekgd10@gmail.com' => 'bibekBishwokarma12',
    'chandanch19@gmail.com' => 'chandanChadhary07',
];

// Loop through each admin and update their password
foreach ($admins as $email => $new_password) {
    // Hash the password using PHP's password_hash function
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Update the password in the admin table
    $stmt = $connection->prepare('UPDATE admin SET password = ? WHERE email = ?');
    $stmt->bind_param('ss', $hashed_password, $email);
    $stmt->execute();
}

// Close the connection
$connection->close();

echo 'Passwords updated successfully for the admins.';
?>
