<?php
require "session.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the database
// Check if we are on the live server or a local XAMPP environment
if ($_SERVER['SERVER_NAME'] == 'knuth.griffith.ie') {
    // Path for the Knuth server
    $path_to_mysql_connect = '../../../mysql_connect.php';
} else {
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
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {

	// check if the email is provided
	if(empty($_POST['email'])) {
		$errors[] = 'Please enter your email';
	} else {
		$email = validate_form_input($_POST['email']);
	}

	// validate if password is empty
    if (empty($_POST['password'])) {
        $errors[] = 'Please enter your password';
    } else {
    	$password = validate_form_input($_POST['password']);
    }



	if (empty($errors)) {
		// prepare and execute the SELECT query
        $stmt = $db_connection->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
        	// get the user data from the database
            $row = $result->fetch_assoc();

            // verify the password
            if (password_verify($password, $row['password'])) {
            	$_SESSION["role"] = $row['role'];
                $_SESSION["user"] = $row;

                if(isset($_POST['rememberMe']) && $_POST['rememberMe']) {
                	//Use session_set_cookie_params instead of cookies for security reasons
                	//session_set_cookie_params(lifetime);

	                echo 'true';
            	}


            	// Redirect the user to home page
                header("location: index.php");
                exit;
            } else {
            	$errors[] = 'The password is not valid';
            }
        } else {
        	$errors[] = "No User exist with that email. <a href='sign_up.php'>Sign up</a>";
        }
        $stmt->close();
    }
    // Close connection
    mysqli_close($db_connection);
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		 <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- connect bootstrap libraries -->
        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" media="screen">
        <title>Login</title>
        <link rel="stylesheet" href="style/style.css">
	</head>

	<body id="loginPage">
		<main class="d-flex justify-content-center mt-5">
			<div id="login">
				<div class="d-flex justify-content-end mt-2 mr-2">
					<a href="index.php">
						<button type="button" id="closeButton" class="btn btn-outline-secondary">&#x2715;</button>
					</a>
				</div>
				<h2 class="text-center">Log in</h2>
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
					    <label for="email">Email address</label>
					    <input type="text" id="email" name="email" class="form-control" placeholder ="example@domain.com" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
					</div>

					<div class="form-group mr-3 ml-3">
						<label for="password">Password</label>
						<input type="password" id="password" name="password"class="form-control">
					</div>

					<div class="form-check text-start ml-3">
				     	<input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe" value="true">
				     	<label class="form-check-label" for="flexCheckDefault"> Remember for 30 days</label>
				    </div>

				    <div class="form-group text-center mt-3 pr-3 pl-3">
	                   	    <input type="submit" name="login" class="btn btn-outline-primary w-100" value="Log in">
	                </div> 

	                 <p class="text-center">Don't have an account? <a href="sign_up.php">Sign up</a></p>
	                 <p class="text-center"><a href="reset_password.php">Forgot your password?</a></p>
				</form>
			</div>
		</main>
		<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>