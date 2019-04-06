<?php

// http://dev-tips.com/featured/ajax-and-php-contact-form

// If the form have been submitted and the spam check field is empty
if(isset($_POST['contactName'])) {

	// Enter your email
	
	$mail = "rohith@rohithmvk.com"; // Your email here

	// Include our email validator for later use
	require 'inc/email-validator.php';
	$validator = new EmailAddressValidator();
	
	// Declare our $errors variable we will be using later to store any errors.
	$errors = array();

	$name = strip_tags($_POST['contactName']);
	$emailfrom = strip_tags($_POST['contactEmail']);
	$subject = strip_tags($_POST['contactSubject']);
	$message = utf8_decode($_POST['contactMessage']); // Use uft8_decode to make special characters �, �, �, � and � work
	
	if(empty($subject)) { $subject = "Default subject"; } // Set a default subject if the user didn't enter one
	
	// We'll check and see if any of the required fields are empty.
	// We use an array to store the required fields.
	$required = array('Name' => 'contactName', 'Email' => 'contactEmail', 'Message' => 'contactMessage');
		
	// Loops through each required $_POST value
	// Checks to ensure it is not empty.
	foreach ( $required as $key => $value ) {
		if(isset($_POST[$value]) && $_POST[$value] !== '')
			continue;
		else
			$errors[] = $key . ' cannot be left blank';
	}
	
	// Make sure the email is valid.
    if (!$validator->check_email_address($emailfrom))
           $errors[] = 'Email address is invalid';
	
	// Now check to see if there are any errors
	if(empty($errors)) {
	
		$ok = "ok";
		// No errors, send mail using conditional to ensure it was sent.
		if(mail($mail, "$subject", $message, "From: $emailfrom"))
			echo '<p class="success">Your email has been sent</p>';
		else
			echo '<p class="error">There was a problem sending your email</p>';
	
	} else {
	
		// Errors were found, output all errors to the user.
		echo '<p class="error">';
			echo implode('<br />', $errors);
		echo '</p>';

	}

} else { // The user have tried to access thid page directly or this a spambot
	echo "You're not allowed to access this page directly";
}

?>