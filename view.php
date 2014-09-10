<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Gallery</title>
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

	$username = $_GET['user'];
	$albumTitle = $_GET['albumTitle'];
	$picPath = $_GET['picPath'];
	$albumHome = "album.php?user=" . $username . "&albumTitle=" . $albumTitle;

	print ("<h3><a href=$albumHome>Return to album home</a></h3>");

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

	// theoretically should never return false/null
	$startIndex = array_search($picPath, $imgPaths);

	$numElements = count($imgPaths);

?>

	</br></br>
	</br>
	<button onclick="previous();">Previous</button>&nbsp; &nbsp; &nbsp; <button onclick="next();">Next</button>
	</br>
	
	<script type="text/javascript">

		// collect this image's picTitle
		// collect this image's previous and next entry in table
		// if next is clicked, display that next entry in table, update current entry, then next and previous entry in table
		// repeat for if previous is clicked
	
		var images = <?php echo json_encode($imgPaths); ?>;
		var names = <?php echo json_encode($picNames); ?>;
		var size = <?php echo $numElements; ?>;
		//var index = 0;
		var index = <?php echo $startIndex; ?>;

		function showImage(src, id) {
			var img = document.createElement("img");
			img.src = src;
			img.id = id;
			img.setAttribute("id", id);
			//img.setAttribute("align", "middle");
			document.body.appendChild(img);
			//document.getElementById(id).align = "middle";
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
			showImage(images[index], names[index]);
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
			showImage(images[index], names[index]);
		}

		showImage(images[index], names[index]);

	</script>


	
<?php

	close($db_server);

?>

</body>
</html>
