<?php

	$MAX_LINE_WIDTH = 80;
	$MAX_MESSAGE_LENGTH = 400;
	$MAX_FACT_LENGTH = 250;

	$debug = FALSE;

	if ($debug) { error_reporting(E_ALL); }

	// NONE OF THESE FUNCTIONS HAVE ERROR CHECKING (WHERE APPLICABLE)

	//$db_server = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	function connect() {
		$db_server = new mysqli('z', 'bc23784', 'ygYXyRgsOB', 'cs105_bc23784');
		if ($db_server->connect_errno) {
			die ("<h1> There was an error:</h1> <p> " . $db_server->connect_error . "</p>");
			//return false;
		}
		return $db_server;
	}

	function close($db_server) {
		$db_server->close();
		if ($db_server->connect_errno) {
			dieErrMessage();
		}
	}

	function checkQueryResults($result) {
		if (!$result) {
			die ("<h1> There was an error:</h1> <p> " . $db_server->connect_error . "</p>");
		}
		return true;	
	}

	function userExists($username, $db_server) {
		// search database to see if user already exists
		$userExists = false;
		$query = "SELECT * FROM users WHERE username=" . "'" . $username . "'";
		$result = $db_server->query($query);

		if (!$result) {
			// error executing the query
			printErrMessage();
		}
		else {
			// check
			if ($result->num_rows > 0) {
				return true;
			}
			return false;
		}
	}

	// requires an entry for the user to already be in the profiles table
	// no precondition check!
	function updateProfFacts($fact1, $fact2, $fact3, $username, $db_server) {
		$query = "SELECT * FROM profiles WHERE username='$username'";
		$result = $db_server->query($query);
		checkQueryResults($result);

		$row = $result->fetch_row();
		if (strlen($fact1) > 0) {
			$fact1 = $db_server->real_escape_string($fact1);
			$query = "UPDATE profiles SET fact1='$fact1' WHERE username='$username';";
			$result = $db_server->query($query);
			checkQueryResults($result);
			echo "<p>Fact 1 successfully updated.</p>";
		}	
		if (strlen($fact2) > 0) {
			$fact2 = $db_server->real_escape_string($fact2);
			$query = "UPDATE profiles SET fact2='$fact2' WHERE username='$username';";
			$result = $db_server->query($query);
			checkQueryResults($result);
			echo "<p>Fact 2 successfully updated.</p>";
		}
		if (strlen($fact1) > 0) {
			$fact3 = $db_server->real_escape_string($fact3);
			$query = "UPDATE profiles SET fact3='$fact3' WHERE username='$username';";
			$result = $db_server->query($query);
			checkQueryResults($result);
			echo "<p>Fact 3 successfully updated.</p>";
		}	
	}

	function search() {
		?>		
				<form id="Search" action="search.php" enctype="multipart/form-data" method="POST" style = "display: inline;">
					<input type="submit" value="Search">
					<input type="text" name="search" placeholder="USE ME (but be gentle)" />
				</form>
		<?php
	}

	function printToolbar($username, $isProfPage) {
		if (!isEmptyString($username) && !$isProfPage) {
			//echo	"<div style = \"text-align:left; float:left;\">
			//		<a href=profile.php?user=$username> Home</a> &nbsp;&nbsp;&nbsp; <a href=index.php> Index</a> &nbsp;&nbsp;&nbsp; <a href=newalbum1.php>
			//		Create Album</a> &nbsp;&nbsp;&nbsp; <a href=testupload1.php> Upload Image</a> &nbsp;&nbsp;&nbsp; <a href=logout.php>Sign Out ($username)</a>
			//		
			//		</br></div>";
			echo	"&nbsp;&nbsp;&nbsp;<a href=profile.php?user=$username>Home</a> &nbsp;&nbsp;&nbsp; <a href=index.php> Index</a> &nbsp;&nbsp;&nbsp; <a href=newalbum1.php>
					Create Album</a> &nbsp;&nbsp;&nbsp; <a href=testupload1.php> Upload Image</a> &nbsp;&nbsp;&nbsp; <a href=logout.php>Sign Out ($username)</a>
					" . search() . "
					</br>";			
			return true;
		}
		else if (!isEmptyString($username) && $isProfPage) {
			echo	"&nbsp;&nbsp;&nbsp;
					<a href=profile.php?user=$username>Home</a> &nbsp;&nbsp;&nbsp; <a href=index.php> Index</a> &nbsp;&nbsp;&nbsp; <a href=newalbum1.php>
					Create Album</a> &nbsp;&nbsp;&nbsp; <a href=testupload1.php> Upload Image</a> &nbsp;&nbsp;&nbsp; <a href=update.php?user=$username>Update Profile</a> 
					&nbsp;&nbsp;&nbsp; <a href=logout.php>Sign Out ($username)</a>
					" . search() . "
					</br>";
			return true;
		}
		else if (isEmptyString($username) && $isProfPage) {
			echo	"&nbsp;&nbsp;&nbsp;
					<a href=index.php>Home</a> &nbsp;&nbsp;&nbsp; <a href=signup1.php> Register</a> &nbsp;&nbsp;&nbsp; <a href=newalbum1.php>
					Create Album</a> &nbsp;&nbsp;&nbsp; <a href=testupload1.php> Upload Image</a> &nbsp;&nbsp;&nbsp; <a href=update.php?user=$username>Update Profile</a> 
					&nbsp;&nbsp;&nbsp; <a href=login.php>Sign In</a>
					" . search() . "
					</br>";
			return false;
		}
		else {
			echo	"&nbsp;&nbsp;&nbsp;
					<a href=index.php>Home</a> &nbsp;&nbsp;&nbsp; <a href=signup1.php> Register</a> &nbsp;&nbsp;&nbsp; <a href=newalbum1.php>
					Create Album</a> &nbsp;&nbsp;&nbsp; <a href=testupload1.php> Upload Image</a> &nbsp;&nbsp;&nbsp; <a href=login.php>Sign In</a>
					" . search() . "
					</br>";
			return false;
		}
	}

	function isEmptyString($string) {
		return (trim($string) === "" or $string === null);
	}

/*
	function updateProfPic($filename, $filetype, $filetmpname, $username, $db_server) {
		//if ($_FILES) {
				
			$name = $filename;
			switch($filetype) {
				case 'image/jpeg': $ext = 'jpg'; break;
				case 'image/gif'; $ext = 'gif'; break;
				case 'image/png'; $ext = 'png'; break;
				case 'image/tiff'; $ext = 'tif'; break;
				default: $ext = ''; break;
			}

			if ($ext) {
				$picName = "profile" . "." . $ext;
				$albumRoot = $username;

				// check albums table to see if user has any albums (and thus a root directory)

				$userExists = false;
				//$query = "SELECT * FROM albums WHERE username=" . "'" . $username . "'";
				$query = "SELECT * FROM albums WHERE username='$username'";
				$result = $db_server->query($query);
				checkQueryResults($result);
	
						
				if ($result->num_rows > 0) {
					$userExists = true;
				}

				if (!$userExists) {
					mkdir($albumRoot, 0777, true);
				}

				$tempFile = $filetmpname;
				$path = $albumRoot . "/" . $picName;
						
				if (move_uploaded_file($tempFile, $path)){
					//echo "<p>Image successfully uploaded.</p>";
					chmod($path, 0777);
					$updatedProfPicPath = $path;

					// update profiles table
					$query = "SELECT * FROM profiles WHERE username='$username'";
					$result = $db_server->query($query);
					checkQueryResults($result);
					
					else {
						// technically should check to see if user has an entry, but due to design logic this isn't necessary
						// b/c user must sign up before being able to upload profile pic
											
						$row = $result->fetch_row();
						$profPicPath = $albumRoot . "/" . $picName;
						$query = "UPDATE profiles SET profPicPath='$profPicPath' WHERE username='$username'";
						$result = $db_server->query($query);
						checkQueryResults($query);
						
						echo "<p>Profile picture record successfully updated.</p>";
						
					}
									
				}
				else {
					echo "There was an error uploading the image.</br>";
				}
						
			}
			else {
				echo "<p>File extension not supported or no image was specified.</p>";
			}
		//}
		//else {
			// nothing uploaded
		//	echo "File extension not supported or no image was specified.</br>";
		//}
	}
*/	

?>
