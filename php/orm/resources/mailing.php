<?php
	require_once('vendor/autoload.php');
	
	function email($to, $subject, $body, $attachments=array()){
		
		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->Host = 'relay.unc.edu';

		$mail->From = "caterpillarscount@gmail.com";
		$mail->FromName = "Caterpillars Count!";
		$mail->addAddress($to);
		
		for($i = 0; $i < count($attachments); $i++){
			$mail->addAttachment($attachments[$i]);
		}
	
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AltBody = strip_tags($body);

		if($mail->send()){
	   		return true;
	  	} 
	  	return false;//"Mailer Error: " . $mail->ErrorInfo;
	}
  
  	function advancedEmail($to, $fromAddress, $fromName, $subject, $htmlBody, $altBody, $attachments=array()){
		$mail = new PHPMailer;
	  	$mail->IsSMTP();
	  	$mail->Host = 'relay.unc.edu';

	  	$mail->From = $fromAddress;
	  	$mail->FromName = $fromName;
	  	$mail->addAddress($to);
		
		for($i = 0; $i < count($attachments); $i++){
			$mail->addAttachment($attachments[$i]);
		}
		
	  	$mail->isHTML(true);
	  	$mail->Subject = $subject;
	  	$mail->Body = $htmlBody;
	  	$mail->AltBody = strip_tags($altBody);

	  	if($mail->send()){
	  	   return true;
	  	} 
	  	return false;//"Mailer Error: " . $mail->ErrorInfo;
	}

	$cookieCutterEmails = array(
		"",
		"",
		"",
		"",
		"<html> <head> <meta name=\"viewport\" content=\"user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width\" /> <link href=\"https://fonts.googleapis.com/css?family=Merriweather\" rel=\"stylesheet\"> <link href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:700\" rel=\"stylesheet\"> <style> body{ margin:0px; height:100% !important; margin:0px !important; padding:0px !important; width:100% !important; } header{ background-image:url(\"http://caterpillarscount.unc.edu/images/emailHeaderBackground.jpg\"); background-size:cover; background-position:center; background-repeat:no-repeat; height:164px; background-color:#eee; padding:40px 20px; box-sizing:border-box; } #headerText{ background-image:url(\"http://caterpillarscount.unc.edu/images/emailHeaderText.png\"); background-size:contain; background-position:center; background-repeat:no-repeat; height:100%; width:100%; } main{ padding:20px; max-width:565px; margin:auto; } .panel{ padding:10px 0px; border-bottom:2px solid #eaeaea; } .panel:last-of-type{ border-bottom:0px none transparent; } h1{ font-size: 24px; font-family: \"Source Sans Pro\", \"Helvetica Neue\", Helvetica, Arial, sans-serif; text-align:center; } .panel img{ width:100%; padding:18px 0px; display:block; margin:auto; } p{ margin:0px; font-family: 'Merriweather', Georgia, \"Times New Roman\", serif; font-size:14px; padding:13px 0px; line-height:175%; } .tagline{ font-style:italic; } a{ color:#6faf6d; text-decoration:underline; } button{ border:0px none transparent; background:#89D085; padding:10px; font-size:18px; font-family: \"Source Sans Pro\", \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-weight:bold; color:#fff; border-radius:3px; display:block; margin:18px auto; cursor:pointer; } .note{ background:#89D085; padding:0px 18px; } .table{ display:table; } .cell{ display:table-cell; vertical-align:top; } footer{ padding:45px 18px 63px 18px; background:#083000; text-align:center; color:#fff; font-family: Helvetica; font-size:12px; line-height:150%; } footer>div{ padding:9px 0px; } footer .icon{ padding:0px 9px; width:24px; } footer #copyrightLine{ font-style:italic; } footer a{ color:#fff; } .bold{ font-weight:bold; } .underlined{ text-decoration:underline; } .centeredText{ text-align:center; } @media screen and (max-width: 555px){ header{ height:110px; padding:25 20px; } } </style> </head> <body> <header> <div id=\"headerText\"></div> </header> <main> <div class=\"panel\"> <p class=\"tagline centeredText\">Caterpillars Count! relies on citizen scientists (you!) to help understand some of the most important organisms in our ecosystems&ndash;caterpillars and other insects&ndash;by conducting surveys of the plants and trees around them.</p> <h1>The Season Is Here!</h1> <img src=\"https://caterpillarscount.unc.edu/images/participants_counting4.jpg\"/> <h1 style=\"text-align:left;\">Hi $firstName,</h1> <p>Leaves are out and surveying season is underway in your area! We see that you have registered as a Caterpillars Count! host site, but have not yet submitted any survey data.</p> <p>We just wanted to check in to see how you're doing with Caterpillars Count! and if you have any questions about the surveying process or using the mobile app or website to enter your data.</p> <p>We are here to support you! Check out the <a href=\"https://caterpillarscount.unc.edu/faq/\">FAQ</a>, ask a question on the <a href=\"https://groups.google.com/forum/embed/?place=forum%2Fcaterpillars-count&showsearch=true&showtabs=false&parenturl=https%3A%2F%2Fcaterpillarscount.unc.edu%2Ffaq%2F&theme=default#!forum/caterpillars-count\">Forum</a>, or shoot us an email anytime at <a href=\"mailto:caterpillarscount@gmail.com\">caterpillarscount@gmail.com</a>.</p> <p>Also, if you are using paper datasheets to collect data and have not yet entered your surveys, let us know. Remember to get that data entered as soon as you can, so you can make the most use of the <a href=\"https://caterpillarscount.unc.edu/mapsAndGraphs/\">visualization tools</a> on the website.</p> <p>All the best, and happy counting!</p> <p>The Caterpillars Count! Team</p></div> </main> <footer> <div> <a href=\"https://www.facebook.com/Caterpillars-Count-1854259101283140/\" target=\"_blank\"><img class=\"icon\" src=\"https://caterpillarscount.unc.edu/images/emailFacebookIcon.png\"/></a> <a href=\"https://twitter.com/CaterpillarsCt\" target=\"_blank\"><img class=\"icon\" src=\"https://caterpillarscount.unc.edu/images/emailTwitterIcon.png\"/></a> <a href=\"https://caterpillarscount.unc.edu/\" target=\"_blank\"><img class=\"icon\" src=\"https://caterpillarscount.unc.edu/images/emailLinkIcon.png\"/></a> </div> <div id=\"copyrightLine\">Copyright &copy; 2018 Caterpillars Count!, All rights reserved.</div> <div> <div class=\"bold\">Caterpillars Count!</div> <div>University of North Carolina at Chapel Hill</div> <div><a href=\"mailto:caterpillarscount@gmail.com\">caterpillarscount@gmail.com</a></div> </div> <div>If your site is no longer active, please retire your site by visiting your <a href=\"https://caterpillarscount.unc.edu/manageMySites/\" target=\"_blank\">Manage My Sites</a> page, editing the site, unchecking the \"site will continue submitting surveys\" checkbox, and clicking \"Save Site Settings\".</div> </footer> </body> </html>",
		"<html> <head> <meta name=\"viewport\" content=\"user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width\" /> <link href=\"https://fonts.googleapis.com/css?family=Merriweather\" rel=\"stylesheet\"> <link href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:700\" rel=\"stylesheet\"> <style> body{ margin:0px; height:100% !important; margin:0px !important; padding:0px !important; width:100% !important; } header{ background-image:url(\"http://caterpillarscount.unc.edu/images/emailHeaderBackground.jpg\"); background-size:cover; background-position:center; background-repeat:no-repeat; height:164px; background-color:#eee; padding:40px 20px; box-sizing:border-box; } #headerText{ background-image:url(\"http://caterpillarscount.unc.edu/images/emailHeaderText.png\"); background-size:contain; background-position:center; background-repeat:no-repeat; height:100%; width:100%; } main{ padding:20px; max-width:565px; margin:auto; } .panel{ padding:10px 0px; border-bottom:2px solid #eaeaea; } .panel:last-of-type{ border-bottom:0px none transparent; } h1{ font-size: 24px; font-family: \"Source Sans Pro\", \"Helvetica Neue\", Helvetica, Arial, sans-serif; text-align:center; } .panel img{ width:100%; padding:18px 0px; display:block; margin:auto; } p{ margin:0px; font-family: 'Merriweather', Georgia, \"Times New Roman\", serif; font-size:14px; padding:13px 0px; line-height:175%; } .tagline{ font-style:italic; } a{ color:#6faf6d; text-decoration:underline; } button{ border:0px none transparent; background:#89D085; padding:10px; font-size:18px; font-family: \"Source Sans Pro\", \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-weight:bold; color:#fff; border-radius:3px; display:block; margin:18px auto; cursor:pointer; } .note{ background:#89D085; padding:0px 18px; } .table{ display:table; } .cell{ display:table-cell; vertical-align:top; } footer{ padding:45px 18px 63px 18px; background:#083000; text-align:center; color:#fff; font-family: Helvetica; font-size:12px; line-height:150%; } footer>div{ padding:9px 0px; } footer .icon{ padding:0px 9px; width:24px; } footer #copyrightLine{ font-style:italic; } footer a{ color:#fff; } .bold{ font-weight:bold; } .underlined{ text-decoration:underline; } .centeredText{ text-align:center; } @media screen and (max-width: 555px){ header{ height:110px; padding:25 20px; } } </style> </head> <body> <header> <div id=\"headerText\"></div> </header> <main> <div class=\"panel\"> <p class=\"tagline centeredText\">Caterpillars Count! relies on citizen scientists (you!) to help understand some of the most important organisms in our ecosystems&ndash;caterpillars and other insects&ndash;by conducting surveys of the plants and trees around them.</p> <h1>We're Here To Help!</h1> <img src=\"https://caterpillarscount.unc.edu/images/trainingparticipants_thumbnail.jpg\"/> <h1 style=\"text-align:left;\">Hi Aaron,</h1> <p>Just checking in again to see if you need any support using the Caterpillars Count! tools or conducting surveys. We haven't yet seen any survey data come in for your site.</p> <p>If you are using paper datasheets to conduct your surveys, remember to enter your data regularly using the <a href=\"https://caterpillarscount.unc.edu/submitObservations/\">Submit Observations</a> page on the website, under the Participate tab. Once you have data entered for your site, you can use the visualization tools on the website.</p> <p>We do recommend you use the new and improved Caterpillars Count! app when conducting your surveys, if possible. The app has some built&ndash;in checks to ensure data quality, cuts down on data transcription errors and eliminates a step in data entry &ndash; any data entered in the field will be saved in the app and automatically upload when you reconnect to wifi.</p> <p>Remember, we are here to support you! Check out the <a href=\"https://caterpillarscount.unc.edu/faq/\">FAQ</a>, ask a question on the <a href=\"https://groups.google.com/forum/embed/?place=forum%2Fcaterpillars-count&showsearch=true&showtabs=false&parenturl=https%3A%2F%2Fcaterpillarscount.unc.edu%2Ffaq%2F&theme=default#!forum/caterpillars-count\">Forum</a>, or shoot us an email at <a href=\"mailto:caterpillarscount@gmail.com\">caterpillarscount@gmail.com</a>.</p> <p>All the best, and happy counting!</p> <p>The Caterpillars Count! Team</p> </div> </main> <footer> <div> <a href=\"https://www.facebook.com/Caterpillars-Count-1854259101283140/\" target=\"_blank\"><img class=\"icon\" src=\"https://caterpillarscount.unc.edu/images/emailFacebookIcon.png\"/></a> <a href=\"https://twitter.com/CaterpillarsCt\" target=\"_blank\"><img class=\"icon\" src=\"https://caterpillarscount.unc.edu/images/emailTwitterIcon.png\"/></a> <a href=\"https://caterpillarscount.unc.edu/\" target=\"_blank\"><img class=\"icon\" src=\"https://caterpillarscount.unc.edu/images/emailLinkIcon.png\"/></a> </div> <div id=\"copyrightLine\">Copyright © 2018 Caterpillars Count!, All rights reserved.</div> <div> <div class=\"bold\">Caterpillars Count!</div> <div>University of North Carolina at Chapel Hill</div> <div><a href=\"mailto:caterpillarscount@gmail.com\">caterpillarscount@gmail.com</a></div> </div> <div>If your site is no longer active, please retire your site by visiting your <a href=\"https://caterpillarscount.unc.edu/manageMySites/\" target=\"_blank\">Manage My Sites</a> page, editing the site, unchecking the \"site will continue submitting surveys\" checkbox, and clicking \"Save Site Settings\".</div> </footer> </body> </html>",
		"",
		"",
		""
	);
	function cookieCutterEmail($to, $subject, $emailNumber){
		global $cookieCutterEmails;
		email($to, $subject, $cookieCutterEmails[intval($emailNumber)]);
	}
?>
