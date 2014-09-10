<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>User Registration Confirmation</title>
    <link rel="stylesheet" type="text/css" href="SiteStyle.css" />
</head>

<body>

<?php

	session_unset();
	session_start();

	require "class_lib.php";

	$sessionUsername = $_SESSION['username'];	// this should always be null
	printToolbar($sessionUsername, false);			

	echo "<h1>User Registration Confirmation</h1></br></br>";

	$userValid = TRUE;
	$pwValid = TRUE;
	$fact1Valid = TRUE;
	$fact2Valid = TRUE;
	$fact3Valid = TRUE;

	if (strlen($_POST['username']) > 30) {
		$userValid = FALSE;
	}
	if (strlen($_POST['password1']) > 50 || strlen($_POST['password2']) > 50) {
		$pwValid = FALSE;
	}
	if (strlen($_POST['fact1']) > 250) {
		$fact1Valid = FALSE;
	}
	if (strlen($_POST['fact2']) > 250) {
		$fact2Valid = FALSE;
	}
	if (strlen($_POST['fact3']) > 250) {
		$fact3Valid = FALSE;
	}

	if (!$userValid || !$pwValid || !$fact1Valid || !$fact2Valid || !$fact3Valid) {
		redir($userValid, $pwValid, $fact1Valid, $fact2Valid, $fact3Valid, "You have exceeded the maximum number of allowable characters for the following fields:</br>");
	}

	// length checks
//	if (strlen($_POST['username']) > 30) {
//		echo "Username must not exceed 30 characters in length. Please go back and try again.";
//	}
//	else if (strlen($_POST['password1']) > 50 || strlen($_POST['password2']) > 50) {
//		echo "Password must not exceed 50 characters in length. Please go back and try again.";
//	}
//	else if (strlen($_POST['fact1']) > 250 || strlen($_POST['fact2']) > 250 || strlen($_POST['fact3']) > 250) {
//		echo "Facts must not exceed 250 characters in length. Please go back and try again.";
//	}
//	else {
		$db_server = connect();

		$username = $_POST['username'];

		$userExists = userExists($username, $db_server);
		if (!$userExists) {
		
			$pw1 = $_POST['password1'];
			$pw2 = $_POST['password2'];
			$fact1 = $db_server->real_escape_string($_POST['fact1']);
			$fact2 = $db_server->real_escape_string($_POST['fact2']);
			$fact3 = $db_server->real_escape_string($_POST['fact3']);

		 	// validate names
			// validate passwords match
			// validate passwords contain at least 1 uppercase letter and one number
			// if both conditions satisfied, save
			//	otherwise tell user s/he screwed up

			$checkGood = true;

			// check password != username
			if ($pw1 == $username || $pw2 == $username) {
				echo "Error: password cannot match username.";
				$checkGood = False;
			}

			// check username
			if (preg_match('/[^A-Za-z0-9]/', $username)) {
				echo "Error: usernames must only contain letters and numbers.";
				$checkGood = False;
			}

			// check passwords match
			if (!($pw1 == $pw2)) {
			   	echo "Error: passwords do not match.";
			   	$checkGood = False;
			}

			// check password length
			if (strlen($pw1) < 6) {
			   	echo "Error: password must be at least 6 characters long.";
			   	$checkGood = False;
			}

			// check password for special character
			// change to disallow colons/semicolons?
			$hasLetter = preg_match('/[a-zA-Z]/', $pw1);
			$hasNumber = preg_match('/[0-9]/', $pw1);
			$hasSymbol = (((!preg_match('/[a-zA-Z]/', $pw1)) && (!preg_match('/[0-9]/', $pw1))));
			if (($hasLetter && $hasNumber && $hasSymbol)) {
				echo "Error: password must contain at least one uppercase character 
					and one symbol (~, #, $, %, ^, &, *, + -, !, ?, etc)";
				$checkGood = False;
			}

			// if validation is successful, update records
			if ($checkGood) {
				$fixedPass = hash('sha1', $_POST['password1'], false);
				$query = "INSERT INTO users(username, password) VALUES ('$username', '$fixedPass');";
				$result = $db_server->query($query);
				checkQueryResults($result);

				// create a new entry in profiles table, and save facts
				$query = "INSERT INTO profiles(username, fact1, fact2, fact3, profPicPath) 
					VALUES('$username', '$fact1', '$fact2', '$fact3', '');";
				$result = $db_server->query($query);
				checkQueryResults($result);

				// begin save profile image
				//$updateSuccess = updateProfPic($username, $db_server);

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

						mkdir($albumRoot, 0777, true);

						$tempFile = $_FILES['file']['tmp_name'];
						chmod($tempFile, 0777);
						$path = $albumRoot . "/" . $picName;
						
						if (move_uploaded_file($tempFile, $path)){
							//echo "<p>Image successfully uploaded.</p>";
							chmod($path, 0777);
							$updatedProfPicPath = $path;

							// update profiles table
							$query = "SELECT * FROM profiles WHERE username=" . "'" . $_POST['username'] . "'";
							$result = $db_server->query($query);
							if (!$result) {
								print ("<h1> There was an error:</h1> <p> " . $db_server->error . "</p>");
							}
							else {
								// technically should check to see if user has an entry, but due to design logic this isn't necessary
								// b/c user must sign up before being able to upload profile pic
											
								$row = $result->fetch_row();
								$profPicPath = $albumRoot . "/" . $picName;
								$query = "UPDATE profiles SET profPicPath='$profPicPath' WHERE username=" . "'" . $_POST['username'] . "'";
								$result = $db_server->query($query);
								if (!$result) {
									print ("<h1> There was an error:</h1> <p> " . $db_server->error . "</p>");
								}
								else {
									//echo "<p>Profile picture record successfully updated.</p>";
									$_SESSION['username'] = $username;
									header('Location: index.php');
									exit();
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
				// end saving profile image

			

			}
		}
		else {
			// user already exists
			echo "Username already exists!</br>";
		}
//	}

	function redir($userValid, $pwValid, $fact1Valid, $fact2Valid, $fact3Valid, $errMsg) {

		if (!isEmptyString($errMsg)) {
			echo $errMsg;
		}
		else {
			echo "The following fields are invalid:</br>";
		}
		
		if (!$userValid) {
			echo "&nbsp&nbsp&nbsp&nbsp- username</br>";
		}
		if (!$pwValid) {
			echo "&nbsp&nbsp&nbsp&nbsp- password</br>";
		}
		if (!$fact1Valid) {
			echo "&nbsp&nbsp&nbsp&nbsp- fact 1</br>";
		}
		if (!$fact2Valid) {
			echo "&nbsp&nbsp&nbsp&nbsp- fact 2</br>";
		}
		if (!$fact3Valid) {
			echo "&nbsp&nbsp&nbsp&nbsp- fact 3</br>";
		}
		echo "</br>";
		print("<hr />");
		?>

		<form action="signup2.php" enctype="multipart/form-data" method="POST">
			Username: <input type="text" name="username" value="<?php if ($userValid) { echo $_POST['username']; } ?>"></br>
			Password*: <input type="password" name="password1" value="<?php if ($pwValid) { echo $_POST['pw1']; } ?>"></br>
			Re-enter password: <input type="password" name="password2 value="<?php if ($pwValid) { echo $_POST['pw1']; } ?>"></br></br>

			Any fields below left blank will remain unchanged.

			<p>
				<label for="file">Choose a profile picture:</label>
				<input id="file" type="file" name="file">
				</br>
				Supported file extensions: .jpg, .gif, .png, .tif
			</p>

			Enter 3 facts about yourself (limit 250 characters each):</br></br>
				Fact 1: </br><textarea onKeyPress="return taLimit(this)" onKeyUp="return taCount(this, 'fact1Count')" 
							name="fact1" cols="60" rows="3"><?php if ($fact1Valid) { echo $_POST['fact1']; } ?></textarea>
				</br>You have <B><SPAN id=fact1Count>250</SPAN></B> characters remaining for Fact 1.</br></br>
				Fact 2: </br><textarea onKeyPress="return taLimit(this)" onKeyUp="return taCount(this, 'fact2Count')" 
							name="fact2" cols="60" rows="3"><?php if ($fact1Valid) { echo $_POST['fact2']; } ?></textarea>
				</br>You have <B><SPAN id=fact2Count>250</SPAN></B> characters remaining for Fact 2.</br></br>
				Fact 3: </br><textarea onKeyPress="return taLimit(this)" onKeyUp="return taCount(this, 'fact3Count')" 
							name="fact3" cols="60" rows="3"><?php if ($fact1Valid) { echo $_POST['fact3']; } ?></textarea>
				</br>You have <B><SPAN id=fact3Count>250</SPAN></B> characters remaining for Fact 3.</br></br>

			<p>*must be at least 6 characters long and contain at least one uppercase letter and one symbol (~, #, $, %, ^, &, *, +, -, :, ;, !, ?, etc)</p>
		
			<input type="submit" value="Submit">
		</form>
		
		<?php
	}


	close($db_server);
	
?>

</body>
</html>
