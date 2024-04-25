<?php
require "session.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Generate a random 6-digit code
$code = rand(100000,999999);

$email = $_SESSION['email'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$title = 'Verify your email address';
$body = "
<html>
	<head>
  		<title>Your Verification Code</title>
	</head>
	<body>
 		<p>Dear $firstName $lastName,</p>
 		<p>Your verification code is: <strong>$code</strong></p>
  		<p>Please use this code to verify your email address.</p>
  		<p>Kind regards,</p>
  		<p>Letopia Support</p>
	</body>
</html>
";

mail($email, $title, $body, 'From: letopia@gmail.com');





//if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['continue']) && isset($_SESSION['email'])) {
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['continue'])) {
	
	GLOBAL $code;
	echo $code;
}


?>
<html lang="en">
	<head>
		 <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- connect bootstrap libraries -->
        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" media="screen">
        <title>Email Verification</title>
        <link rel="stylesheet" href="style/style.css">
	</head>

	<body>
		<main>
			<div class="container mt-5" id="emailVerificationForm">
				<div class="d-flex justify-content-center align-items-center flex-column">
				<figure class="mt-5">
					<img src="emailcon.png" alt="✉">
				</figure>
				<h1>Verify your email address</h1>
				<h3>An email with a verification code has been sent to</h3>
				<h3><b><?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?></b></h3>
				<form id="emailVerification" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="POST" novalidate>
					<div class="form-group mt-2 mb-4" id="inputCode">
	                    <label for="code" class="col-form-label col-form-label-lg">Enter the code here:</label>
	                    <input type="text" id="code" class="form-control form-control-lg" name="code" class="form-control">
	                </div>

	                <div class="form-group text-center">
	                		<a href="sign_up.php">
		   						<button type="button" class="btn btn-outline-secondary" >← Back</button>
							</a>
	                    <input type="submit" name="continue" class="btn btn-primary" value="Continue">
	                </div>
				</form>
			</div>
			</div>
		</main>
	</body>
</html>