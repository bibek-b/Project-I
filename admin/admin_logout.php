<?php
session_start();

// Unset only admin-related session variables
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);

// Optionally destroy the admin session only
session_write_close();

// Redirect to the admin login page
header('Location: ../business/login.php');
exit;
?>