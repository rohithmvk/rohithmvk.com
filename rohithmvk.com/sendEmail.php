<?php

// Replace this with your own email address
$siteOwnersEmail = 'rohith@rohithmvk.com';
require 'inc/email-validator.php';
$validator = new EmailAddressValidator();
// Declare our $errors variable we will be using later to store any errors.
	$errors = array();
if($_POST) {

  // $name = trim(stripslashes($_POST['contactName']));
   //$email = trim(stripslashes($_POST['contactEmail']));
   //$subject = trim(stripslashes($_POST['contactSubject']));
   //$contact_message = trim(stripslashes($_POST['contactMessage']));   
   $name = trim(strip_tags($_POST['contactName']));
   $email = trim(strip_tags($_POST['contactEmail']));
   $subject = trim(strip_tags($_POST['contactSubject']));
   $contact_message = trim(utf8_decode($_POST['contactMessage']));

   // Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Please enter your name.";
	}
	// Check Email
	if (!$validator->check_email_address($email))
           $error['email'] = = 'Please enter a valid email address.';
	
	//if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
	//	$error['email'] = "Please enter a valid email address.";
	//}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Please enter your message. It should have at least 15 characters.";
	}
   // Subject
	if ($subject == '') { $subject = "Contact Form Submission"; }


   // Set Message
   $message .= "Email from: " . $name . "<br />";
   $message .= "Email address: " . $email . "<br />";
   $message .= "Message: <br />";
   $message .= $contact_message;
   $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


   if (!$error) {
		$ok = "ok";
      //ini_set("sendmail_from", $siteOwnersEmail); // for windows server
     //$mail = mail($siteOwnersEmail, $subject, $message, $headers);
      if (mail($siteOwnersEmail, $subject, $message,"From: $email"))
	  {
		echo "OK"; 
	}
      else { 
	  $mail = mail($siteOwnersEmail, $subject, $message,"From: $email");
	  echo "Something went wrong. Please try again.Error:$mail"; 
	  }
		
	} # end if - no validation error

	else {

		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}

?>