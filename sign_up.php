<?php 
require_once ("session.php");

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
    $path_to_mysql_connect = __DIR__ . '/../../../mysql_connect.php';
}

// Require the mysql_connect.php file using the determined path
require_once $path_to_mysql_connect;

// Create an empty array to store errors
$errors = [];
$noError = true;


function validate_form_input($input) {
    $input = trim($input); // Remove whitespace from the beginning and end of the string

    //Remove carriage return characters
    $input = str_replace("\r","", $input);
    //Remove new line characters
    $input = str_replace("\n","", $input);

    if (empty($input)) {
       return false; // Input is empty after trimming, so return false
    }


    $input = strip_tags($input); // Remove HTML and PHP tags
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Convert special characters to HTML entities
    return $input; // Return the sanitized input
}


// Checks if form is submitted via POST and sanitizes input to prevent XSS attacks.
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signUp'])) {
    // Check and validate 'First Name' field
    if(isset($_POST['firstName']) && !empty($_POST['firstName'])) {
        $firstName = validate_form_input($_POST['firstName']);
        //Capitalises the first character
        $firstName = ucfirst($firstName);

        if ($firstName === false) {
            $errors[] = "First Name is missing.";
        }
        // 50 it is varchar limit in the table. The last name may contain apostrophe ex. O'Connor. After validate_for_input this last name will look like O\'Connor (suitable for SQL)
        $regex = "/^([a-zA-Z]|\\'|\\\\){1,50}/";
        if(!preg_match($regex, $firstName)) {
            $errors[] = "First Name is in the wrong format.";
        }
    } else {
        $errors[] = "First Name is missing.";
    }

    // Check and validate 'Last Name' field
    if(isset($_POST['lastName']) && !empty($_POST['lastName'])) {
        $lastName = validate_form_input($_POST['lastName']);
        //Capitalises the first character
        $lastName = ucfirst($lastName);

        if ($lastName === false) {
            $errors[] = "Last Name is missing.";
        }
        // 50 it is varchar limit in the table. The last name may contain apostrophe ex. O'Connor. After validate_for_input this last name will look like O\'Connor (suitable for SQL)
        $regex = "/^([a-zA-Z]|\\'|\\\\){1,50}/";
        if(!preg_match($regex, $lastName)) {
            $errors[] = "Last Name is in the wrong format.";
        }
    } else {
        $errors[] = "Last Name is missing.";
    }

    // Validate password
    $passwordAcceptable = false;
    if(isset($_POST['password']) && !empty($_POST['password'])) {
        $password = trim($_POST['password']);
        //Minimum eight characters, at least one letter, one number and one special character:
        $regex = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
        if(!preg_match( $regex,$password )) {
            $errors[] = "Your password must contain at least 8 characters, at least 1 letter, 1 number including at least 1 special character.";
        } else {
            $passwordAcceptable = true;
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
        }

    } else {
       $errors[] = "Password is missing."; 
    }

    // Validate confirm password
    if($passwordAcceptable) {
        if(isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
          $confirm_password = trim($_POST["confirm_password"]);
          if($password != $confirm_password) {
            $errors[] = "Password did not match.";
          } 
        } else {
            $errors[] = "Confirmation password is missing.";
        }
    }

    // check if the email is provided and is valid
    if (empty($_POST['email'])) {
        $errors[] = 'Email is required.';
    } else {
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }
    }

    if($query = $db_connection->prepare("SELECT * FROM user WHERE email = ?")) {
        // Bind parameters (s = string, i = int), username is a string so use "s"
        $query->bind_param('s', $email);
        $query->execute();
        // Store the result so we can check if the account exists in the database.
        $query->store_result();
        if ($query->num_rows > 0) {
            // Duplicate record found, display error message
                $alert = <<<ALERT
                <div class="text-dark alert alert-warning text-center mt-2" role="alert">
                <h4><b>$email</b> record already exists. <a href ='login.php?email=$email'>Log In</a></h4>
                </div>
ALERT;
            echo $alert;
        } elseif (!empty($errors)) {
            GLOBAL $noError;
            $noError = false;
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger text-center mb-2' role='alert'>
                    {$error}
                </div>";
            }
        } else {
            //Email verification
        }

        $query->close(); 
    }
    
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
        <link rel="stylesheet" href="style.css">
	</head>
    <body>
        <main>
            <div class="container mt-3">
                <div class="row">
                    <div class="col-md-5 mt-3 w-50" id="signUp">
                        <h2 class="text-center mt-2">Sign up</h2>
                        <p class="text-center text-secondary">Please fill this form to create an account.</p>
                        <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="POST" novalidate>

                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="firstName" class="form-control" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>">
                            </div>
                                    
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="lastName" class="form-control" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                                <p class="text-secondary">Your password must contain at least 8 characters, at least 1 letter, 1 number including at least 1 special character.</p>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="emai;">Email</label>
                                <input type="text" id="email" name="email" class="form-control" placeholder ="example@domain.com" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
                            </div>

                            <div class="form-group text-center mt-4">
                                <input type="submit" name="signUp" class="btn btn-outline-success w-50 " value="Sign Up">
                            </div>
                        </form>
                    </div>
                </div>
                 <h5 class="text-center mt-4">Already have an account? <a href="login.php">Login here</a></h5>
            </div>
        </main>
    </body>
</html>
