<?php
    // Include the database configuration file
    require_once '../config/database.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $name = $_POST['name'];

        // Validate the fields
        if (empty($name)) {
            // Handle empty fields error
            echo 'Please enter a group name.';
            echo '<a href="contacts.php">Go back</a>';
            exit;
        }
        
        // Create a new database instance
        $db = new Database();
        $pdo = $db->connect();

        // Check if the group name is unique
        $query = "SELECT * FROM groups WHERE name = :name";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Handle duplicate group name error
            echo 'Group name is already registered.';
            echo '<a href="contacts.php">Go back</a>';
            exit;
        }

        // Insert the data into the database
        $query = "INSERT INTO groups (name) VALUES (:name)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        // end the database connection
        $pdo = null;

        // Redirect to the contacts page
        header('Location: contacts.php');
        exit;
    }
    echo 'Form submission error.';
    echo '<a href="contacts.php">Go back</a>';
    exit;
?>