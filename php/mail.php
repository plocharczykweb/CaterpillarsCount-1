<?php
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require '../vendor/autoload.php';

//PHPMailer Object
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->Host = 'relay.unc.edu';  // UNC's SMTP relay server

//From email address and name
$mail->From = "mail@caterpillarscount.unc.edu";
$mail->FromName = "Caterpillars Count";

//To address and name
//$mail->addAddress("recepient1@example.com", "Recepient Name");
$mail->addAddress("plocharczykweb@gmail.com"); //Recipient name is optional

//Address to which recipient will reply
$mail->addReplyTo("caterpillarscount@gmail.com", "Reply");

//CC and BCC
//$mail->addCC("cc@example.com");
//$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Test phpmailer";
$mail->Body = "<i>Mail body in HTML</i>";
$mail->AltBody = "This is the plain text version of the email content";

if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 
{
    echo "Message has been sent successfully";
}
?>
