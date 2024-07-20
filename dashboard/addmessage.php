<?php
    // Include the database configuration file
    require_once '../config/database.php';
    require_once '../vendor/autoload.php';
    require_once '../vendor/pear/http_request2/HTTP/Request2.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $message = $_POST['message'];
        $group_id = $_POST['group_id'];

        // Validate the fields
        if (empty($message)) {
            // Handle empty fields error
            echo 'Please Enter a message.';
            echo '<a href="group.php?id='.$group_id.'">Go back</a>';
            exit;
        }
        
        // Create a new database instance
        $db = new Database();
        $pdo = $db->connect();

        // Insert the data into the database
        $query = "INSERT INTO messages (message, group_id) VALUES (:message, :group_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->execute();

        // Get the message ID
        $message_id = $pdo->lastInsertId();

        try {
            // Send the message to the group members
            $query = "SELECT * FROM recepients WHERE group_id = :group_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':group_id', $group_id);
            $stmt->execute();

            $recepients = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($recepients as $recepient) {
                // Send the message
                $to = $recepient['phone'];
                $request = new HTTP_Request2();
                $request->setUrl('https://y3zq8j.api.infobip.com/sms/2/text/advanced');
                $request->setMethod(HTTP_Request2::METHOD_POST);
                $request->setConfig(array(
                    'follow_redirects' => true
                ));
                $request->setHeader(array(
                    'Authorization' => 'App 2f06cf3eb14d2aa6c59288765bd7da16-2552b2f4-146d-4e3c-b50f-b45b2d3d3573',
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ));
                $request->setBody('{"messages":[{"destinations":[{"to":"'.$to.'"}],"from":"ServiceSMS","text":"'.$message.'"}]}');
                try {
                    $response = $request->send();
                    if ($response->getStatus() == 200) {
                        // Set the message status to sent
                        $query = "UPDATE messages SET status = 'success' WHERE id = :id";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':id', $message_id);
                        $stmt->execute();
                    }
                    else {
                        // Set the message status to failed
                        $query = "UPDATE messages SET status = 'failed' WHERE id = :id";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':id', $message_id);
                        $stmt->execute();
                    }
                }
                catch(HTTP_Request2_Exception $e) {
                    // Handle message sending error
                    // Set the message status to failed
                    $query = "UPDATE messages SET status = 'failed' WHERE id = :id";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':id', $message_id);
                    $stmt->execute();

                    echo 'Message sending failed.';
                    echo '<a href="group.php?id='.$group_id.'">Go back</a>';
                    exit;
                }
            }
        } catch (Exception $e) {
            // Handle message sending error
            // Set the message status to failed
            $query = "UPDATE messages SET status = 'failed' WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $message_id);
            $stmt->execute();

            echo 'Message sending failed.';
            echo '<a href="group.php?id='.$group_id.'">Go back</a>';
            exit;
        }

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