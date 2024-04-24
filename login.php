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
					<div class="form-group mr-3 ml-3">
					    <label for="email">Email address</label>
					    <input type="text" id="email" name="email" class="form-control" placeholder ="example@domain.com" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
					</div>

					<div class="form-group mr-3 ml-3">
						<label for="password">Password</label>
						<input type="password" id="password" name="password"class="form-control" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>">
					</div>

					<div class="form-check text-start ml-3">
				     	<input class="form-check-input" type="checkbox" id="remember-me" name="remember-me" value="remember-me">
				     	<label class="form-check-label" for="flexCheckDefault"> Remember for 30 days</label>
				    </div>

				    <div class="form-group text-center mt-3 pr-3 pl-3">
	                   	    <input type="submit" name="submit" class="btn btn-outline-primary w-100" value="Log in">
	                </div> 

	                 <p class="text-center">Don't have an account? <a href="sign_up.php">Sign up</a></p>
	                 <p class="text-center"><a href="reset_password.php">Forgot your password?</a></p>
				</form>
			</div>
		</main>
		<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>