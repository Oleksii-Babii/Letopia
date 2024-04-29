<?php 
require "session.php";
require ('templates/header.php');

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
if(isset($_GET['token'])) {
$_SESSION['token'] = $_GET['token'];
}

// Checks if form is submitted via POST and sanitizes input to prevent XSS attacks.
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset'])) {

    $token = $_SESSION['token'];
    $tolen_hash = hash("sha256", $token);

    $stmt = $db_connection->prepare("SELECT * FROM user WHERE reset_token_hash = ?");

    $stmt ->bind_param("s",$tolen_hash);

    $stmt -> execute();
    $result = $stmt -> get_result();
    $user = $result ->fetch_assoc();

    if($user === null) {
        die("token not found");
    }

    if(strtotime($user["reset_token_expires_at"]) <= time()) {
        die("Token has expired");
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
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
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

    if(empty($errors)){

    	 $stmt = $db_connection->prepare("UPDATE user SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?");

    	 $stmt -> bind_param("ss", $passwordHash, $user["id"]);
    	 $stmt -> execute();

    	 $updated = true;


    }

}

 ?>

 <main id="forgotPassword">
            <div class="container"> 
                <div class="row">
                    <?php if(isset($updated)): ?>
                        <div class="alert alert-success" role="alert">
                              <h3>Password updated. You can now <a href="login.php">Log In</a>.</h3>
                        </div>
                    <?php else: ?>  
                    <div class="col-md-4 mt-3 w-50" id="signUp">                    
                        <h2 class="text-center mt-2">Reset Password</h2>
                        <p class="text-center text-secondary">Enter your new password.</p>
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
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                                <p class="text-secondary">Your password must contain at least 8 characters, at least 1 letter, 1 number including at least 1 special character.</p>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>

                            <div class="form-group text-center mt-4">
                                <input type="submit" name="reset" class="btn btn-primary" value="Reset Password">
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </body>
</html>