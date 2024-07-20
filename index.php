<?php
    // Start the session. The session is used to store the user's authentication status
    session_start();

    // Check if the user is authenticated
    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
        // Redirect to the dashboard
        header('Location: ./dashboard/index.php');
        exit;
    } else {
        // Redirect to the login page
        header('Location: ./auth/login.php');
        exit;
    }
?>