<?php
    // Include the database configuration file
    require_once '../config/database.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $group_id = $_POST['group_id'];

        // Validate the fields
        if (empty($name) || empty($phone)) {
            // Handle empty fields error
            echo 'Please fill in all the fields.';
            echo '<a href="group.php?id='.$group_id.'">Go back</a>';
            exit;
        }
        
        // Create a new database instance
        $db = new Database();
        $pdo = $db->connect();

        // Check if the recepient's phone is unique
        $query = "SELECT * FROM recepients WHERE phone = :phone AND group_id = :group_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Handle duplicate phone error
            echo 'Phone number is already registered in this group.';
            echo '<a href="group.php?id='.$group_id.'">Go back</a>';
            exit;
        }

        // Insert the data into the database
        $query = "INSERT INTO recepients (name, phone, group_id) VALUES (:name, :phone, :group_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->execute();

        // end the database connection
        $pdo = null;

        // Redirect to the group page
        header('Location: group.php?id='.$group_id);
        exit;
    }
    echo 'Form submission error.';
    echo '<a href="contacts.php">Go back</a>';
    exit;
?>