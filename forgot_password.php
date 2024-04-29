<?php 
require "session.php";
require ('templates/header.php');

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


$firstName = '';
// Create an empty array to store errors
$errors = [];

// Checks if form is submitted via POST and sanitizes input to prevent XSS attacks.
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])) {

	// check if the email is provided and is valid
    if (empty($_POST['email'])) {
        $errors[] = 'Email is required.';
    } else {
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        } else {
        	// prepare and execute the SELECT query
	        $stmt = $db_connection->prepare("SELECT * FROM user WHERE email = ?");
	        $stmt->bind_param("s", $email);
	        $stmt->execute();
	        $result = $stmt->get_result();
	        if ($result->num_rows == 0) {
	        	$errors[] = "No User exist with that email. <a href='sign_up.php'>Sign up</a>";
	        } else {
	        	 // Fetch the result as an associative array
				 $user = $result->fetch_assoc();
				 // Store the first name in session
				$firstName = $user['firstName'];
				$_SESSION['email'] = $email;
	        }
	        $stmt->close();
	    }
    }

    if(empty($errors)) {
    	// convent token to hexadecimal 
    	$token = bin2hex(random_bytes(16));

    	$token_hash = hash("sha256", $token);

    	//Expite after 1 hour
    	$expiry = date("Y-m-d H:i:s",time() + 60 * 60);
    	$stmt = $db_connection->prepare("UPDATE user SET reset_token_hash = ? , reset_token_expires_at = ?
    	WHERE email = ?");

    	$stmt -> bind_param("sss",$token_hash,$expiry,$email);

    	if ($stmt ->execute()) {


		// Include the mailer.php file and instantiate the $mail object
		$mail = require_once "mailer.php";

		// Check if $mail is an object
		if (is_object($mail)) {
		    // Set the sender email address
		    $mail->setFrom("letopia@gmail.com");
		    $mail->addAddress($email);

		    // Set the email subject
		    $mail->Subject = "Password Reset";

		    // Set the email body
			$mail->Body = "
			<html>
			<head>
			<title>Welcome to Letopia</title>
			<style>
			  body {
			    font-family: Arial, sans-serif;
			    background-color: #f2f2f2;
			    color: #333;
			  }
			  .container {
			    width: 80%;
			    margin: 0 auto;
			    padding: 20px;
			    background-color: #fff;
			    border-radius: 5px;
			    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
			  }
			  .footer {
			    text-align: center;
			    margin-top: 20px;
			  }
			  .footer img {
			    width: 100px; /* Adjust the width as needed */
			    height: auto;
			  }
			  .reset-button {
			    background-color: #4CAF50;
			    border: none;
			    color: white;
			    padding: 15px 32px;
			    text-align: center;
			    text-decoration: none;
			    display: inline-block;
			    font-size: 16px;
			    margin: 4px 2px;
			    cursor: pointer;
			    border-radius: 5px;
			  }
			</style>
			</head>
			<body>
			  <div class='container'>
			    <h1>Dear $firstName,</h1>
			    <p>If you want to reset your password, click the button below:</p>
			    <a href='http://localhost/Scripts/Letopia/reset_password.php?token=$token' class='reset-button'>Reset Password</a>
			    <p>The link is valid for 1 hour.</p>
			    <p>If you have any questions, reach out to us at <a href='mailto:letopia@gmail.com'>letopia@gmail.com</a></p>
			    <p>Kind regards,</p>
			    <h3>Letopia Support Team</h3>
			  </div>
			  <div class='footer'>
			    <img src='additionalResources/footer-logo.png' alt='Letopia Logo'>
			  </div>
			</body>
			</html>
			";

		    try {
		        // Try to send the email
		        $mail->send();
		        echo "Email sent successfully!";
		    } catch (Exception $e) {
		        // If an error occurs, catch the Exception and display the error message
		        echo "Message could not be sent. {$mail->ErrorInfo}";
		    }
		} else {
		    echo "Error: Failed to instantiate PHPMailer object.";
		}
		       



    		// Email subject
			// $subject = "Password Reset";
			// $body = <<<END
			// <a href="https://knuth.griffith.ie/~s3104904/ass03/forgot_password.php?token=$token">Reset password</a>
			// END;

    		// mail($email, $subject, $body, 'From: noreply@letopia.com');

    		
    		//Redirect
			header("Location: email_verification.php?type=reset&email=$email");
    	}

    
    }
}

?>
        <main id="forgotPassword">
            <div class="container"> 
                <div class="row">
                    <div class="col-md-4 mt-3 w-50" id="signUp">
                        <h2 class="text-center mt-2">Reset Password</h2>
                        <p class="text-center text-secondary">Confirm your email to reset your password.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="POST" novalidate>
                            <?php
                                if (!empty($errors)) {
                                    foreach ($errors as $error) {
                                        echo "<div class='alert alert-danger text-center mb-1 ml-1 mr-1' role='alert'>
                                        {$error}
                                    </div>";
                                    }
                                }
                             ?>

                            <div class="form-group">
                                <label for="emai;">Email</label>
                                <input type="text" id="email" name="email" class="form-control" placeholder ="example@domain.com" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
                            </div>

                            <div class="form-group text-center mt-4">
                                <input type="submit" name="send" class="btn btn-primary w-25 " value="Send">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>