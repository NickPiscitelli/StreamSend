<?php

// Initialize vars
$errors = array();
$error_messages = array(
	'Please fill out all required fields.',
	'Please enter a valid e-mail address.',
	'E-mail address is already reigstered.',
	'An unexpected error occurred.',
	// Return generic error for login to prevent brute force e-mail fetching
	'Incorrect e-mail address and/or password.'
);

// Initialize DB connection
$con = mysqli_connect("localhost","stream_admin","<redacted>","stream_send");
if (mysqli_connect_errno()){
  die("Failed to connect to MySQL: " . mysqli_connect_error());
}


if ($_POST['register']){
	
	// Validate Email
	if(!filter_var($_POST['reg_email'], FILTER_VALIDATE_EMAIL)){
		$errors['reg_email'] = 1;
		$errors['code'] = 1;
	}
	// Validate Required Fields
	foreach (array('first_name','last_name','password') as $key){
		if (empty($_POST[$key])){
			$errors[$key] = 1;
			$errors['code'] = 0;
		}
	}
	// Confirm no errors before querying DB for distinct e-mail check
	if (!count(array_keys($errors))){

		// Check if e-mail is registered
		$email = mysqli_real_escape_string($con, $_POST['reg_email']);
		if (duplicateEmail($email)){
			$errors['code'] = 2;
		}else {

			// Create Salted Hash
			$salt = uniqid(mt_rand(), true);
			$password = hash('sha256',$_POST['password'].$salt);
			
			// Quote other data to insert
			$password = mysqli_real_escape_string($con, $password);
			$escaped_salt = mysqli_real_escape_string($con, $salt);
			$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
			$last_name = mysqli_real_escape_string($con, $_POST['last_name']);
			
			// Execute query
			$sql = "INSERT INTO users VALUES (NULL,'$email','$password','$first_name','$last_name','$escaped_salt');";
			
			if (!mysqli_query($con,$sql)) {
				$errors['code'] = 3;
			}else{
				// Update session and redirect
				$_SESSION['name'] = $_POST['first_name'];
				$_SESSION['logged_in'] = 1;
				header('Location: results.php');
			}
		}

	}

} else if ($_POST['login']){
	//Validate e-mail
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$errors['email'] = 1;
		$errors['login'] = 1;
	}
	// Check password exists
	if (empty($_POST['password'])){
		$errors['password'] = 1;
		$errors['login'] = 1;
	}
	
	// Check if errors are present before fetching salt.
	if (!count(array_keys($errors))){

		// Fetch salt
		$email = mysqli_real_escape_string($con, $_POST['email']);
		$salt = fetchSalt($email);

		// Check login status
		if ($salt){

			$password = hash('sha256',$_POST['password'].$salt);
			$password = mysqli_real_escape_string($con, $password);
			$sql = "SELECT first_name FROM users WHERE email = '$email' AND password = '$password'";
			$result = mysqli_query($con,$sql);
			$row = mysqli_fetch_array($result);

			if ($row['first_name']){
				// Update session and redirect
				$_SESSION['name'] = $row['first_name'];
				$_SESSION['logged_in'] = 1;
				header('Location: results.php');
			}else{
				$errors['login'] = 1;
				$errors['code'] = 4;
			}
		}else{
			$errors['login'] = 1;
			$errors['code'] = 4;
		}
	}
}

// Set error message if present
$errors['message'] = $errors['code'] ? $error_messages[$errors['code']] : '';

function duplicateEmail($email){
	global $con;
	$result = mysqli_query($con,"SELECT count(1) as dup FROM users WHERE email = '$email'");
	$row = mysqli_fetch_array($result);
	return $row['dup'] ? 1 : 0;
}

function fetchSalt($email){
	global $con;
	$result = mysqli_query($con,"SELECT salt FROM users WHERE email = '$email'");
	$row = mysqli_fetch_array($result);
	return $row['salt'];
}

?>
