<?php
	require_once('vendor/autoload.php');
	
	function email($to, $subject, $body){
		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->Host = 'relay.unc.edu';

		$mail->From = "caterpillarscount@gmail.com";
		$mail->FromName = "Caterpillars Count!";
		$mail->addAddress($to);
	
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AltBody = strip_tags($body);

		if($mail->send()){
	   		return true;
	  	} 
	  	return false;//"Mailer Error: " . $mail->ErrorInfo;
	}
  
  	function advancedEmail($to, $fromAddress, $fromName, $subject, $htmlBody, $altBody){
		$mail = new PHPMailer;
	  	$mail->IsSMTP();
	  	$mail->Host = 'relay.unc.edu';

	  	$mail->From = $fromAddress;
	  	$mail->FromName = $fromName;
	  	$mail->addAddress($to);
	
	  	$mail->isHTML(true);
	  	$mail->Subject = $subject;
	  	$mail->Body = $htmlBody;
	  	$mail->AltBody = strip_tags($altBody);

	  	if($mail->send()){
	  	   return true;
	  	} 
	  	return false;//"Mailer Error: " . $mail->ErrorInfo;
	}	
?>
