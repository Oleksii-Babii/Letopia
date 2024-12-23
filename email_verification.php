<?php
require "session.php";
require ('templates/header.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_SESSION['email']) && isset($_SESSION['firstName'])&& isset($_SESSION['lastName'])) {
	// Send an email with a verification code to the user's email
	// $email = $_SESSION['email'];
	// $firstName = $_SESSION['firstName'];
	// $lastName = $_SESSION['lastName'];
	// $title = 'Verify your email address';
	// $body = "
	// <html>
	// 	<head>
	//   		<title>Your Verification Code</title>
	// 	</head>
	// 	<body>
	//  		<p>Dear $firstName $lastName,</p>
	//  		<p>Your verification code is: <strong>$code</strong></p>
	//   		<p>Please use this code to verify your email address.</p>
	//   		<p>Kind regards,</p>
	//   		<p>Letopia Support</p>
	// 	</body>
	// </html>
	// ";

	// mail($email, $title, $body, 'From: letopia@gmail.com');
}



//if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['continue']) && isset($_SESSION['email'])) {
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['continue'])) {

	//default  by now
	header("Location: sign_up.php?approvedEmail=true");


	//Check if code and user code matches
	/*
	if matches
		header to sign_up : approvedEmail=true
	else 
		header to sign_up: approvedEmail=false
	*/
	
	

	// GLOBAL $code;
	// echo $code;
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
			<div id="emailVerification">
				<div class="container mt-5" id="emailVerificationForm">
					<div class="d-flex justify-content-center align-items-center flex-column">
						<figure class="mt-5">
							<img src="additionalResources/emailcon.png" alt="✉">
						</figure>
						<h1>Verify your email address</h1>
						<h3>An email with instructions for verification has been sent to the address</h3>
						<h3 class="mb-5"><b><?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?></b></h3>
					</div>
				</div>
			</div>
		</main>
	</body>
</html>