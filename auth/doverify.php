<?php
    // Include the database configuration file
    require_once '../config/database.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $code = $_POST['code'];

        // Validate the fields
        if (empty($code)) {
            // Handle empty fields error
            echo 'Please fill in the code.';
            echo '<a href="verify.php">Go back</a>';
            exit;
        }
        // if code is not 4 digits
        if (strlen($code) !== 4) {
            // Handle invalid code error
            echo 'Invalid code.';
            echo '<a href="verify.php">Go back</a>';
            exit;
        }        
        
        // Start the session. The session is used to store the user's authentication status
        session_start();

        // Create a new database instance
        $db = new Database();
        $pdo = $db->connect();

        // Check if the user exists
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            // Handle non-existent user error
            echo 'User does not exist.'.$_SESSION['user_id'];
            echo '<a href="logout.php">Go back</a>';
            exit;
        }

        // Get the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the code matches
        if ($code != $user['code']) {
            // Handle incorrect code error
            echo 'Incorrect code.';
            echo '<a href="verify.php">Go back</a>';
            exit;
        }

        // Update the user's verified_at field
        $query = "UPDATE users SET verified_at = NOW() WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();

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
?>