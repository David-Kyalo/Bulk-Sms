<?php
    // Include the database configuration file
    require_once '../config/database.php';
    require_once '../vendor/autoload.php';
    require_once '../vendor/pear/http_request2/HTTP/Request2.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Validate the fields
        if (empty($name) || empty($phone) || empty($password) || empty($confirmPassword)) {
            // Handle empty fields error
            echo 'Please fill in all the fields.';
            echo '<a href="register.php">Go back</a>';
            exit;
        }

        if ($password !== $confirmPassword) {
            // Handle password mismatch error
            echo 'Password and confirm password do not match.';
            echo '<a href="register.php">Go back</a>';
            exit;
        }
        
        // Create a new database instance
        $db = new Database();
        $pdo = $db->connect();

        // Check if the phone number is unique
        $query = "SELECT * FROM users WHERE phone = :phone";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Handle duplicate phone number error
            echo 'Phone number is already registered.';
            echo '<a href="register.php">Go back</a>';
            exit;
        }

        // Hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // create a random 4-digit code
        $code = rand(1000, 9999);

        // Insert the data into the database
        $query = "INSERT INTO users (name, phone, password, code) VALUES (:name, :phone, :password, :code)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':code', $code);
        $stmt->execute();

        // end the database connection
        $pdo = null;

        // send message to the user
        $message = "Your verification code is ".$code;
        $to = $phone;
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
        } catch (HttpException $ex) {
            // Handle HTTP exception
            echo 'An error occurred while sending the OTP.';
            echo '<a href="login.php">Just Login</a>';
            exit;
        }
        // complete the code to send the message

        // Redirect to the login page
        header('Location: login.php');
        exit;
    }
    echo 'Form submission error.';
    echo '<a href="register.php">Go back</a>';
    exit;
?>