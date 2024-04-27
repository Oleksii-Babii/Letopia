<?php
require "session.php";

ini_set('display_errors', 1);
ini_set('dispaly_startup',1);
error_reporting(E_ALL);

// Connect to the database
// Check if we are on the live server or a local XAMPP environment
if($_SERVER['SERVER_NAME'] == 'knuth.griffith.ie'){
    // Path for the Knuth server
    $path_to_mysql_connect = '../../../mysql_connect.php';
}else{
    // Path for the local XAMPP server
    $path_to_mysql_connect = 'mysql_connect.php';
}

// Require the mysql_connect.php file using the determined path
require_once $path_to_mysql_connect;

// Create an empty array to store errors
$errors = [];
$noError = true;
//Get validate_form_input function
require 'functions.php';

// Define addContact function
function addContact($db_connection, $name, $email, $phone, $message){
    $insertQuery = $db_connection->prepare("INSERT INTO contact_us (`name`, `email`,`phone`, `message`) VALUES (?, ?, ?, ?);");
    $insertQuery->bind_param("ssss", $name, $email, $phone, $message);
    $result = $insertQuery->execute();

    if ($result) {
        //Data inserted successfully. Display the corresponding message
        $success = <<<SUCCESS
        <div class="alert alert-success text-center" role="alert">
            <h4 class="alert-heading">Congratulations!</h4>
            <h5>Your message is sent to us.</h5>
            <hr>
        </div>
        SUCCESS;
        
        echo $success;
    } else {
        echo "<p class='error'>Something went wrong: '.$insertQuery->error.'</p>";
    }

    $insertQuery->close();
}

// Checks if form is submitted via POST and sanitizes input to prevent XSS attacks.
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])){

    //check if the email is provided
    if(empty($_POST['email'])){
        $errors[] = 'Please enter your email';
    }else{
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
        }
        
    }


    //check if the full name is not empty
    if(empty($_POST['full_name'])){
        $errors[] = 'Please enter your full name';
    }else{
        $name = validate_form_input($_POST['full_name']);
    }

    //check if the phone in not empty
    if(empty($_POST['phone'])){
        $errors[] = 'Please enter your phone number';
    }else{
        $phone = validate_phone_number($_POST['phone']);

        if ($phone === false) {
          $errors[] = "Invalid phone number.";
        }
    }

    if(empty($_POST['message'])){
        $errors[] = 'Please enter your message';
    }else{
        $message = validate_form_input($_POST['message']);
    }

    if(empty($errors)){
        addContact($db_connection, $name, $email, $phone, $message);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>
<body>
    <main class="d-flex justify-content-center mt-5">
        <div id="login">
            <h2 class="text-center">Contact us</h2>
            <p class="text-center text-secondary">Enter your account details below.</p>
            <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" novalidate>
                <?php
                 if (!empty($errors)) {
                    GLOBAL $noError;
                      $noError = false;
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger text-center mb-1 ml-1 mr-1' role='alert'>
                        {$error}
                    </div>";
                    }
                   } ?>

                <div class="form-group mr-3 ml-3">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name"class="form-control" placeholder ="your name" value="<?php if(isset($_POST['full_name'])) echo $_POST['full_name']; ?>">
                </div>

                <div class="form-group mr-3 ml-3">
                    <label for="email">Email address</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder ="example@domain.com" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
                </div>

                <div class="form-group mr-3 ml-3">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder ="your phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>">
                </div>

                <div class="form-group mr-3 ml-3">
                    <label for="message">Your message</label>
                    <textarea id="message" name="message" class="form-control" placeholder ="your message"><?php if(isset($_POST['message'])) echo $_POST['message']; ?></textarea>
                </div>

                <div class="form-group text-center mt-3 pr-3 pl-3">
                           <input type="submit" name="send" class="btn btn-outline-primary w-100" value="Send">
                </div> 
            </form>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
