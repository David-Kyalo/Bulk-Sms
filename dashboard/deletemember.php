<?php
    // Include the database configuration file
    require_once '../config/database.php';

    // this is a GET request. The group ID is passed as a query parameter
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        // Get the recepients ID
        $recId = $_GET['id'];
        
        // Create a new database instance
        $db = new Database();
        $pdo = $db->connect();

        // Get the recepients details
        $query = "SELECT * FROM recepients WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $recId);
        $stmt->execute();

        $recepient = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the recepient exists
        if ($stmt->rowCount() > 0) {
            // Delete the recepient
            $query = "DELETE FROM recepients WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $recId);
            $stmt->execute();

            // Redirect to the recepient's group page
            header('Location: group.php?id='.$recepient['group_id']);
            exit;
        }
        // Handle invalid recepient error
        echo 'Recepient not found. <a href="contacts.php">Go back</a>';
        exit;
    }
    // Handle invalid request error
    echo 'Invalid request.';
    header('Location: contacts.php');
    exit;
?>