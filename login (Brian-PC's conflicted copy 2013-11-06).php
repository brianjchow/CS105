<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

	<body>

	<?php
		session_start();

		require "class_lib_test.php";

		$username = $_SESSION['username'];
		printToolbar($username, false);
	?>

		<h1>
			User Login
		</h1>

		<form id="Login" action="loginHandler.php" enctype="multipart/form-data" method="POST">
         
	    	Username: <input type="text" name="username"><br>
	    	Password: <input type="password" name="password"><br>

    		<p>
            <input id="submit" type="submit" name="submit" value="Submit"> 
        	</p> 
    	</form>

	</body>
</html>
