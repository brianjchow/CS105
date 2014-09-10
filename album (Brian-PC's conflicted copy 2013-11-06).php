<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Album</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<body>

<?php

	session_start();

	require "class_lib_test.php";

	$sessionUsername = $_SESSION['username'];
	printToolbar($sessionUsername, false);

	$db_server = connect();
	
	$username = $_GET['user'];
	$albumTitle = $_GET['albumTitle'];

	print ("<h1>$albumTitle</h1>");
	print ("<h3><a href=profile.php?user=" . $username . ">Back to profile</a></h3>");

	$username = $_GET['user'];
	$albumTitle = $_GET['albumTitle'];
	$picPath = $_GET['picPath'];
	$offset = (strlen($username)) + (strlen($albumTitle)) + 2;
	$picName = substr($picPath, $offset);
	$albumHome = "album.php?user=" . $username . "&albumTitle=" . $albumTitle;

	$query = "SELECT * FROM pictures WHERE username=" . "'" . $_GET['user'] . "'";
	$result = $db_server->query($query);
	checkQueryResults($result);

	$imgPaths = array();
	$picNames = array();
	while($row = $result->fetch_row()) {
		if ($albumTitle == $row[1]) {
			$imgPaths[] = $username . "/" . $albumTitle . "/" . $row[3];
			$picNames[] = $row[3];
		}
	}

	$numElements = count($imgPaths);

// SWITCH VERSIONS BEGINNING HERE

		$query = "SELECT * FROM pictures WHERE username="  . "'" . $_GET['username'] . "'" ." AND albumTitle=" . "'" . $_GET['albumTitle'] . "'";
		$result = $db_server->query($query);
		checkQueryResults($result);

		$path = $username . "/" . $albumTitle . "/";
		$images = glob($path . "*.{jpg, gif, png, tif}", GLOB_BRACE);
		$max_per_row = 4;
		$item_count = 0;

		echo "<div align = 'center'><table><tr align = 'center'>";

		foreach ($images as $image) {
			if ($item_count == $max_per_row) {
				echo "</tr><tr align = 'center'>";
				$item_count = 0;
			}

			$delete = "delete.php?user=" . $username . "&albumTitle=" . $albumTitle . "&picPath=" . $image;
			$view = "view.php?user=" . $username . "&albumTitle=" . $albumTitle . "&picPath=" . $image;
		
			print "<td><a href='" . $view . "'><img src='" . $image . "' height = 400 width = 320 /></a>
					</br>
					<a href='" . $delete . "'><input type=button value=Delete /></a></br></td>";
			
			$item_count++;
		}

		echo "</tr></table></div>";		
	
// SWITCH VERSIONS ENDING HERE

	close($db_server);

/*
	function viewAlbumRemoved() {
			?>

				<script type="text/javascript">
					var images = <?php echo json_encode($imgPaths); ?>;
					var names = <?php echo json_encode($picNames); ?>;
					var size = <?php echo $numElements; ?>;
					var index = 0;
					var width = 320;
					var height = 400;

						var img = document.createElement("img");
						img.src = images[0];
						img.width = width;
						img.height = height;
						img.id = names[0];
						img.setAttribute("id", id);
						document.body.appendChild(img);

					function show_image(src, width, height, id) {

						var img = document.createElement("img");
						img.src = src;
						img.width = width;
						img.height = height;
						img.id = id;
						img.setAttribute("id", id);
						document.body.appendChild(img);
						document.getElementById(id).align = 'center';
					}	

					function previous() {

						if (document.getElementById(names[index])) {
							var temp = document.getElementById(names[index]);
							document.body.removeChild(temp);
						}

						if (index == 0) {
							index = size - 1;
						}
						else {
							index = index - 1;
						}
						show_image(images[index], width, height, names[index]);
					}

					function next() {

						if (document.getElementById(names[index])) {
							var temp = document.getElementById(names[index]);
							document.body.removeChild(temp);
						}

						if (index == (size - 1)) {
							index = 0;
						}
						else {
							index = index + 1;
						}
						show_image(images[index], width, height, names[index]);
					}

				</script>

				</br></br>
				</br>
				<div align='center'><button onclick="previous();">Previous</button>&nbsp; &nbsp; &nbsp; <button onclick="">Delete</button>&nbsp; &nbsp; &nbsp; <button onclick="next();">Next</button></div>
				</br>
	
	
			<?php
	}

	function oldold() {
		$query = "SELECT * FROM pictures WHERE username="  . "'" . $_GET['username'] . "'" ." AND albumTitle=" . "'" . $_GET['albumTitle'] . "'";
		$result = $db_server->query($query);
		checkQueryResults($result);

		$path = $username . "/" . $albumTitle . "/";
		$images = glob($path . "*.{jpg, gif, png, tif}", GLOB_BRACE);
		$max_per_row = 4;
		$item_count = 0;

		echo "<div align='center'><table><tr>";

		foreach ($images as $image) {
			if ($item_count == $max_per_row) {
				echo "</tr><tr>";
				$item_count = 0;
			}

			$delete = "delete.php?user=" . $username . "&albumTitle=" . $albumTitle . "&picPath=" . $image;
			$view = "view.php?user=" . $username . "&albumTitle=" . $albumTitle . "&picPath=" . $image;
		
			print "<td><img src='" . $image . "' height = 400 width = 320/></br> <a href=$delete>Delete</a> &nbsp&nbsp&nbsp <a href=$view>View</a></td>";
			
			$item_count++;
		}

		echo "</tr></table></div>";
	}

	// partially working JS version
	function old() { 
		$query = "SELECT * FROM pictures WHERE username="  . "'" . $_GET['username'] . "'" ." AND albumTitle=" . "'" . $_GET['albumTitle'] . "'";
		$result = $db_server->query($query);
		checkQueryResults($result);

		$path = $username . "/" . $albumTitle . "/";
		$images = glob($path . "*.{jpg, gif, png, tif}", GLOB_BRACE);
		$max_per_row = 4;
		$item_count = 0;

		echo "<div align='center'><table><tr>";

		foreach ($images as $image) {
			if ($item_count == $max_per_row) {
				echo "</tr><tr>";
				$item_count = 0;
			}

			$delURL = "delete.php?user=" . $username . "&albumTitle=" . $albumTitle . "&picPath=" . $image;
			$viewURL = "view.php?user=" . $username . "&albumTitle=" . $albumTitle . "&picPath=" . $image;

			print "<td>";
			?>
				<input type = "image" src = "<?php echo $image; ?>" height = "400" width = "320" onclick = "viewImg();" />
				</br>
				<input type = "button" value = "Delete" onclick = "delImg();" />

				<script type = "text/javascript">
					var imgSrc = <?php echo json_encode($image); ?>;
					var delURL = <?php echo json_encode($delURL); ?>;
					var viewURL = <?php echo json_encode($viewURL); ?>;
					var request;

					function connect() {
						if (window.XMLHttpRequest) {
							request = new XMLHttpRequest();
						}
						else if (window.ActiveXObject) {
							try {
								request = new ActiveXObject("Msxml2.XMLHTTP");
							}
							catch (e) {
								try {
									request = new ActiveXObject("Microsoft.XMLHTTP");
								}
								catch (e) {
									alert("Stop using Internet Explorer dammit");
									self.location = "profile.php?user=" + toUser;
								}
							}
						}
						else {
							alert("Your browser must be as old as you are");
							self.location = "profile.php?user=" + toUser;
						}
					}

					function viewImg(username, albumTitle, imgSrc) {
						connect();
						request.open('GET', viewURL, true);
						request.send(null);
						//var viewURL = "view.php?user=" + username + "&albumTitle=" + albumTitle + "&picPath=" + imgSrc;
						self.location = viewURL;

						// do something with onreadystatechange?

						return false;
					}

					function delImg(username, albumTitle, imgSrc) {
						connect();
						request.open('GET', delURL, true);
						request.send(null);
						//var delURL = "delete.php?user=" + username + "&albumTitle=" + albumTitle + "&picPath=" + imgSrc;
						self.location = delURL;

						// do something with onreadystatechange?	

						return false;				
					}
				</script>

			<?php
			
			$item_count++;
		}

		echo "</tr></table></div>";
	}
*/

?>

</body>
</html>
