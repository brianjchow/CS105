<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<body>

<?php

	session_unset();
	session_start();
	require "class_lib.php";

	$debug = false;

	if ($debug) { error_reporting(E_ALL); }

	// check if session has already been started
		// if so, destroy current session
	// validate credentials
	
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$db_server = connect();
		// validate credentials
		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = "SELECT * FROM users WHERE username='$username'";
		$result = $db_server->query($query);
		checkQueryResults($result);

		$row = $result->fetch_row();
		$fixedPass = hash('sha1', $password, false);
		if ($fixedPass == $row[1]) {
			// user/pw combo correct; kill any current sessions, initiate new session, redirect to index

			$_SESSION['username'] = $username;

			if ($debug) { print_r($_SESSION); }
				

			// redirect to index page
			header('Location: index.php');
			exit(0);

			//echo "<h1>Unknown error. If you have disabled cookies, please re-enable them.</br><a href = login.php>Return</a> to login page</br></h1>";
			//session_destroy();
			//$sessionStarted = session_start();
			//header('Location: index.php');

		}
		else {
			// user doesn't exist or password is incorrect
			echo "User doesn't exist or incorrect password</br><a href = login.php>Return</a> to login page</br> ";
		}

		close($db_server);
		
	}
	//else {
		// not isset
	//}

?>
		
</body>
	
</html>

