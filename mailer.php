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
// or 465 
$mail -> Port = 587;
$mail ->Username = "oleksiibabii2@gmail.com";
$mail -> Password = "pepm lprk wowj qczh";
$mail ->isHtml(true);
return $mail;

?>