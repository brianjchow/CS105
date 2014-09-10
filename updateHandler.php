<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Update Profile</title>
<link rel="stylesheet" type="text/css" href="siteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<body>

<?php

	session_start();

	require "class_lib.php";

	$sessionUsername = $_SESSION['username'];
	printToolbar($sessionUsername, false);

	$db_server = connect();

	$username = $_POST['username'];

	echo "</br>";

	if ($sessionUsername != $username) {
		echo "<h1>Only the owner of the profile may do that.</br>";
	}
	else {
		$fact1 = $_POST['fact1'];
		$fact2 = $_POST['fact2'];
		$fact3 = $_POST['fact3'];

		if (strlen($fact1) > 250 || strlen($fact2) > 250 || strlen($fact3) > 250) {
			echo "Facts must not exceed 250 characters in length. Please go back and try again.";
		}
		else {
			updateProfFacts($fact1, $fact2, $fact3, $username, $db_server);
				

				//$profPicUpdateSuccess = updateProfPic($sessionUsername, $db_server);			
			if ($_FILES) {
				
				$name = $_FILES['file']['name'];
				switch($_FILES['file']['type']) {
					case 'image/jpeg': $ext = 'jpg'; break;
					case 'image/gif'; $ext = 'gif'; break;
					case 'image/png'; $ext = 'png'; break;
					case 'image/tiff'; $ext = 'tif'; break;
					default: $ext = ''; break;
				}

				if ($ext) {
					$picName = "profile" . "." . $ext;
					$albumRoot = $_POST['username'];

					// check albums table to see if user has any albums (and thus a root directory)

					$userExists = false;
					$query = "SELECT * FROM albums WHERE username=" . "'" . $_SESSION['username'] . "'";
					$result = $db_server->query($query);

					// should have !$result check here
						
					if ($result->num_rows > 0) {
						$userExists = true;
					}

					if (!$userExists) {
						mkdir($albumRoot, 0777, true);
					}

					$tempFile = $_FILES['file']['tmp_name'];
					chmod($tempFile, 0777);
					$path = $albumRoot . "/" . $picName;
						
					if (move_uploaded_file($tempFile, $path)){
						//echo "<p>Image successfully uploaded.</p>";
						chmod($path, 0777);
						$updatedProfPicPath = $path;

						// update profiles table
						$query = "SELECT * FROM profiles WHERE username=" . "'" . $_SESSION['username'] . "'";
						$result = $db_server->query($query);
						if (!$result) {
							print ("<h1> There was an error:</h1> <p> " . $db_server->error . "</p>");
						}
						else {
							// technically should check to see if user has an entry, but due to design logic this isn't necessary
							// b/c user must sign up before being able to upload profile pic
											
							$row = $result->fetch_row();
							$profPicPath = $albumRoot . "/" . $picName;
							$query = "UPDATE profiles SET profPicPath='$profPicPath' WHERE username=" . "'" . $_SESSION['username'] . "'";
							$result = $db_server->query($query);
							if (!$result) {
								print ("<h1> There was an error:</h1> <p> " . $db_server->error . "</p>");
							}
							else {
								echo "<p>Profile picture record successfully updated.</p>";
							}
						}
									
					}
					else {
						echo "There was an error uploading the image.</br>";
					}
						
				}
				else {
					echo "<p>File extension not supported or no image was specified.</p>";
				}
			}
			else {
				// nothing uploaded
				echo "File extension not supported or no image was specified.</br>";
			}
		}


	}

	close($db_server);

?>

</body>
</html>
