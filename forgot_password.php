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

    		$mail = require "mailer.php";

    		// Email subject
			// $subject = "Password Reset";
			// $body = <<<END
			// <a href="https://knuth.griffith.ie/~s3104904/ass03/forgot_password.php?token=$token">Reset password</a>
			// END;

    		// mail($email, $subject, $body, 'From: noreply@letopia.com');

    		
    		//Redirect

    		echo "Message sent, please check your indox.";


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