<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Delete Image Confirmation</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<body>

<?php

	session_start();

	require "class_lib.php";
	
	$sessionUsername = $_SESSION['username'];
	printToolbar($sessionUsername, false);

	echo "</br>";

	// 0 for false, 1 for true
	$choice = $_POST['choice'];

	if ($choice == 0) {
		// return to album page
		$temp = "album.php?user=" . $_POST['user'] . "&albumTitle=" . $_POST['albumTitle'];
		echo "No changes made. ";
		echo "<a href=$temp>Click </a>";
		echo "to return to album.</br></br>";
	}
	else {
		// delete picture

		$db_server = connect();
		
		if ($_POST['user'] != $_SESSION['username']) {									
			// owner of picture/album does not match the user logged in	
			echo "Only the owner of the album can delete this picture.</br>";
			$temp = "album.php?user=" . $_POST['user'] . "&albumTitle=" . $_POST['albumTitle'];
			echo "<a href=$temp>Click </a>";
			echo "to return to album.";
		}
		else {


				$username = $_POST['user'];
				$albumTitle = $_POST['albumTitle'];
				$picPath = $_POST['picPath'];

				// delete from directory
				$removed = unlink($picPath);
				$returnPath = $username . "/" . $albumTitle;
				if (!$removed) {
					$temp = "album.php?user=" . $_POST['user'] . "&albumTitle=" . $_POST['albumTitle'];
					echo "There was an error deleting the photo.<a href=$temp> Click</a> to return to album.";
				}
				else {
					// remove successful; delete entry from pictures table

					// parse $picPath
					$picName = (strlen($username)) + (strlen($albumTitle)) + 2;

					// FIX THIS!!!!!!!!!!!!!! I HATE CONCATENATION
						
					//$query = "DELETE FROM pictures WHERE (username=" . "'" . $_POST['user'] . "'" . ") AND (albumTitle=" . "'" . $_POST['albumTitle'] . "'" . ") AND (picTitle=" . "'" . $picName . "'" . ");";		PROBABLY WORKS
					$query = "DELETE FROM pictures WHERE (username=";
					$temp = "'" . $_POST['user'] . "'" . ")";
					$query = $query . $temp;
					$temp = " AND (albumTitle=";
					$query = $query . $temp;
					$temp = "'" . $_POST['albumTitle'] . "'" . ")";
					$query = $query . $temp;
					$temp = " AND (picTitle=";
					$query = $query . $temp;
					$temp = "'" . $picName . "'" . ");";
					$query = $query . $temp;
						
					$result = $db_server->query($query);
					checkQueryResults($result);

					$temp = "album.php?user=" . $_POST['user'] . "&albumTitle=" . $_POST['albumTitle'];
					echo "Picture deleted. <a href=$temp>Click</a> to return to album.</br></br>";
				}
			

		}

		close($db_server);
		
	}
	

?>


</body>
</html>
