<?php
require "session.php";

ini_set('display_errors', 1);
ini_set('dispaly_startup',1);
error_reportion(E_ALL);

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

// Checks if form is submitted via POST and sanitizes input to prevent XSS attacks.
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])){
    
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
            <div class="d-flex justify-content-end mt-2 mr-2">
                <a href="index.php">
                    <button type="button" id="closeButton" class="btn btn-outline-secondary">&#x2715;</button>
                </a>
            </div>
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
                    <label for="phone">Your message</label>
                    <textarea id="message" name="message" class="form-control" placeholder ="your message" value="<?php if(isset($_POST['message'])) echo $_POST['message']; ?>"></textarea>
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