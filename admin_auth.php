<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login page if not logged in
    header('Location: admin_login.php');
    exit;
}

// Optional: Check session timeout (30 minutes)
if (isset($_SESSION['admin_login_time'])) {
    $session_timeout = 30 * 60; // 30 minutes in seconds
    if (time() - $_SESSION['admin_login_time'] > $session_timeout) {
        // Session expired, destroy and redirect
        session_destroy();
        header('Location: admin_login.php?timeout=1');
        exit;
    }
}

// Update last activity time
$_SESSION['admin_login_time'] = time();
?>