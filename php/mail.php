<?php
//require 'vendor/autoload.php';
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->Host = 'relay.unc.edu';  // UNC's SMTP relay server

//From
$mail->From = "caterpillarscount@gmail.com";
$mail->FromName = "Caterpillars Count!";

//To
$mail->addAddress("plocharczykweb@gmail.com"); //or $mail->addAddress("recepient1@example.com", "Recepient Name");

//CC and BCC
//$mail->addCC("cc@example.com");
//$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Test phpmailer";
$mail->Body = "<i>Mail body in HTML</i>";
$mail->AltBody = "This is the plain text version of the email content";

if($mail->send()){
    die("Message has been sent successfully");
} 
die("Mailer Error: " . $mail->ErrorInfo);
?>
