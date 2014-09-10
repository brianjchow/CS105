<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Album Creation Confirmation</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<body>

<?php

	session_start();

	require "class_lib.php";

	$username = $_SESSION['username'];
	printToolbar($username, false);

	$db_server = connect();

	$albumTitle = $_POST['albumTitle'];

	echo "</br>";

	if (preg_match('/[^A-Za-z0-9]/', $albumTitle)) {
		echo "Album names can only contain letters and numbers. Please return to ";
		echo '<a href="newalbum1.html">New Album</a>';
		echo " to try again.</br>";
	}

	if (strlen($albumTitle) > 30) {
		echo "Album title must not exceed 30 characters in length. Please go back and try again.";
	}
	else {

		// check if album exists
		$query = "SELECT * FROM albums WHERE username=" . "'" . $_SESSION['username'] . "'";
		$result = $db_server->query($query);
		checkQueryResults($result);

		$albumExists = false;
		while ($row = $result->fetch_row()) {
			if ($row[1] == $albumTitle) {
				echo "Album already exists!</br>";
				$albumExists = true;
			}
		}

		if (!$albumExists) {
			// album doesn't exist; create it
			$filename = $username . "/" . $albumTitle;
			if (!file_exists($filename)) {
				mkdir($filename, 0777, true);
				echo "Album successfully created!<br />";
					
				// update record
				$query = "INSERT INTO albums(username, albumTitle, albumPath) VALUES ('" . $_SESSION['username'] . "', 
					'" . $_POST['albumTitle'] . "', '" . $filename . "');";
				$result = $db_server->query($query);
				checkQueryResults($result);

				print ("Album record successfully updated.</br>");
			}
			else {
				echo "There was an error creating the album or that album exists already.</br>";
			}
		}
	}
	
	close($db_server);

?>

</body>
</html>

