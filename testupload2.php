<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Image Upload Confirmation</title>
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

	print("<h1>Image Upload Confirmation</h1>");

	$db_server = connect();

	$albumTitle = $_POST['albumTitle'];
	$picTitle = $_POST['picTitle'];

	if (preg_match('/[^A-Za-z0-9]/', $picTitle)) {
		echo "Image names can only contain letters and numbers. Please return to ";
		echo '<a href="testupload1.html">Image Upload</a>';
		echo " to try again.</br>";
	}
	else if (preg_match('/[^A-Za-z0-9]/', $albumTitle)) {
		echo "Album titles can only contain letters and numbers. Please return to ";
		echo '<a href="testupload1.html">Image Upload</a>';
		echo " to try again.</br>";			
	}
	else {
		// upload image

		if (strlen($albumTitle) > 30 || strlen($picTitle) > 30) {
			echo "Album title and/or picture title must not exceed 30 characters in length. Please go back and try again.";
		}
		else {
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
					$n = $picTitle . "." . $ext;

					$query = "SELECT * FROM pictures WHERE username=" . "'" . $_SESSION['username'] . "'";
					$result = $db_server->query($query);
					checkQueryResults($result);

					// query could be shortened by SELECTing username and albumTitle at same time
					$picExists = false;
					while ($row = $result->fetch_row()) {
						if ($row[1] == $albumTitle && $row[3] == $n) {
							$picExists = true;
						}
					}

					if ($picExists) {
						echo "<h3>There is already a picture named \"$picTitle\" in the album \"$albumTitle\". Please re-upload the image with a different name.</h3>";
						print("<hr />");
						redir();						
					}
					else {
						$albumExists = false;
						$query = "SELECT * FROM albums WHERE username=" . "'" . $_SESSION['username'] . "'";
						$result = $db_server->query($query);
						checkQueryResults($result);

						while ($row = $result->fetch_row()) {
							if ($row[1] == $albumTitle) {
								$albumExists = true;
							}
						}

						$filename = $username . "/" . $albumTitle;

						// album doesn't exist; make it and update database
						if (!$albumExists) {
							mkdir($filename, 0777, true);
							echo "New album successfully created.</br>";
							$temp = $db_server->real_escape_string($filename);
							$query = "INSERT INTO albums(username, albumTitle, albumPath)
								VALUES('" . $_SESSION['username'] . "', '" . $_POST['albumTitle'] . "', '$temp')";
							$result = $db_server->query($query);
							checkQueryResults($result);
						}

						$filename = $username . "/" . $albumTitle;
						$path = $username . "/" . $albumTitle . "/" . $n;
						$tempFile = $_FILES['file']['tmp_name'];
						chmod($tempFile, 0777);
				
						if (move_uploaded_file($tempFile, $path)){
							echo "<p>Image successfully uploaded.</p>";
							chmod($path, 0777);

							// update pictures table
							$query = "INSERT INTO pictures(username, albumTitle, albumPath, picTitle)
								VALUES ('" . $_SESSION['username'] . "', '" . $_POST['albumTitle'] . "', 
								'" . $filename . "', '" . $n . "');";
							$result = $db_server->query($query);
							checkQueryResults($result);

							echo "Picture record successfully updated.</br>";
							return true;				
						}
						else {
							// image upload failed
							echo "Image upload failed. Please try again.</br>";
							return false;
						}
					}
				}
				else {
					// invalid file extension
					echo "File extension not supported or no image was specified.</br>";
					return false;
				}
			}
			else {
				echo "No image was specified.</br>";
			}
		}
	}

	function redir() {
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
		    Album title*: <input type="text" name="albumTitle" value="<?php echo $_POST['albumTitle']; ?>"></br>

			</br>* limit 30 characters each</br>

			<p>
		        <input id="submit" type="submit" name="submit" value="Submit"> 
		    </p> 
		 
		</form>
		<?php
	}

	close($db_server);
	
?>

</body>
</html>
