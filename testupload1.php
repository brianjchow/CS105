<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Image Upload</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<body>

<?php

	session_start();

	require "class_lib.php";

	$sessionUsername = $_SESSION['username'];
	$userLoggedIn = printToolbar($sessionUsername, false);

	echo "<h1>Image Upload</h1>";

	if (!$userLoggedIn) {
		echo "You must be logged in to do that. Click <a href=login.php>here</a> to log in. Click <a href=signup1.php>here</a> 
			to sign up for an account.</br>";
	}
	else {
		?>
		<form id="Upload" action="testupload2.php" enctype="multipart/form-data" method="POST">

			<h4>
				Supported file extensions: .jpg, .gif, .png, .tif
				</br>
				Note: specifying an album title for an album that has not yet been created will automatically create the album
			</h4>
		     
		    <p> 
		        <label for="file">Choose a file:</label> 
		        <input id="file" type="file" name="file"> 
		    </p> 
		            
			Picture title*: <input type="text" name="picTitle"></br>
		    Album title*: <input type="text" name="albumTitle"></br>

			</br>* limit 30 characters each</br>

			<p>
		        <input id="submit" type="submit" name="submit" value="Submit"> 
		    </p> 
		 
		</form>
		<?php
	}
?>

</body>
</html>
