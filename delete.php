<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Delete Picture</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<body>

	<?php
		session_start();
		require "class_lib.php";
		$username = $_SESSION['username'];
		$userLoggedIn = printToolBar($username, false);

		echo "</br>";

		if (!$userLoggedIn) {
			echo "You must be logged in to do that. Click <a href=login.php>here</a> to log in. Click <a href=signup1.php>here</a> 
				to sign up for an account.</br>";
		}
		else {
	?>

			</br>
			<form id="Delete" action="deleteHandler.php" enctype="multipart/form-data" method="POST">
				Are you sure? <select name="choice" size="1">

				<option value = "0">No</option>
				<option value = "1">Yes</option>
		
				</select>
		
				<input type = "submit" value = "Submit" />

				<input type = "hidden" name = "user" value = "<?php echo $_GET['user']; ?>">
				<input type = "hidden" name = "albumTitle" value = "<?php echo $_GET['albumTitle']; ?>">
				<input type = "hidden" name = "picPath" value = "<?php echo $_GET['picPath']; ?>">
			</form>	
			
	<?php
				
		}
		
	?>
	
</body>
</html>
