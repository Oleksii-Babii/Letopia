<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail ->isSMTP();
$mail -> SMTPAuth = true;
$mail -> HOST = "smtp.gmail.com";
$mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail -> Port = 587;
$mail ->Username = "you-user@example.com";
$mail -> Password = "your-password";
$mail ->isHtml(true);
return $mail;

?>