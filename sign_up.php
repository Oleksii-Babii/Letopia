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
                                <input type="submit" name="signUp" class="btn btn-success w-100 " value="Sign Up">
                            </div>
                        </form>
                    </div>
                </div>
                 <h5 class="text-center mt-4">Already have an account? <a href="login.php">Login here</a></h5>
            </div>
        </main>
    </body>
</html>
