<?php
session_start();

// Logout logic for both admin and user
if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
} elseif (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}

// Destroy the session entirely
session_destroy();

// Redirect to the login page
header('Location: ../business/login.php');
exit();
