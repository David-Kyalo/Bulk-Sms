<?php
    // Include the database configuration file
    require_once '../config/database.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        // Validate the fields
        if (empty($phone) || empty($password)) {
            // Handle empty fields error
            echo 'Please fill in all the fields.';
            echo '<a href="login.php">Go back</a>';
            exit;
        }

        // Create a new database instance
        $db = new Database();
        $pdo = $db->connect();

        // Check if the phone number exists
        $query = "SELECT * FROM users WHERE phone = :phone";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            // Handle non-existent phone number error
            echo 'Phone number is not registered.';
            echo '<a href="login.php">Go back</a>';
            exit;
        }

        // Get the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if (!password_verify($password, $user['password'])) {
            // Handle incorrect password error
            echo 'Incorrect password.';
            echo '<a href="login.php">Go back</a>';
            exit;
        }

        // Start the session
        session_start();

        // Set the session data
        $_SESSION['authenticated'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['phone'] = $user['phone'];

        // Redirect to the dashboard
        header('Location: ../dashboard/index.php');
        exit;
    }
    else {
        // Handle form submission error due to invalid request method
        echo 'Form submission error.';
        echo '<a href="login.php">Go back</a>';
        exit;
    }
