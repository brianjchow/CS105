<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Profile</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<body>

<?php

	session_start();

	require "class_lib.php";
	
	$sessionUsername = $_SESSION['username'];
	$username = $_GET['user'];
	printToolbar($sessionUsername, true);

	print "<div align='center'><h1> $username </h1></div>";
	
	$db_server = connect();

	// retrieve profile info
	$query = "SELECT * FROM profiles WHERE username=" . "'" . $_GET['user'] . "'";
	$result = $db_server->query($query);
	checkQueryResults($result);

	// print profile picture and facts
	$row = $result->fetch_row();
	$profPicPath = $row[4];
	if (strlen($profPicPath) > 0 && $profPicPath != null) {
		echo "<td><div align='center'><img src='" . $profPicPath . "' height = 400/></br></div></td>";
	}
	print("<div align='center'><h3>$row[1]</br>$row[2]</br>$row[3]</h3></div>");
	//print("<div align='center'><h3>$row[1]</h3></div>");
	//print("<div align='center'><h3>$row[2]</h3></div>");
	//print("<div align='center'><h3>$row[3]</h3></div>");

	print("<hr />");
	print("<h2>List of albums from $username:</h2>");

	$query = "SELECT * FROM albums WHERE username=" . "'" . $_GET['user'] . "'";
	$result = $db_server->query($query);
	checkQueryResults($result);
	
	while ($row = $result->fetch_row()) {
		//print("<h3><a href=album.php?user=$_GET['user']&albumTitle=$row[1]>$row[1]</a></h3>"; 
						$tempAlbumName = $row[1];
						$temp = "album.php?user=" . $username . "&albumTitle=" . $tempAlbumName;
						print( "<h3><a href=$temp>$tempAlbumName</a></h3>");

	}

	print("<hr />");
	print("<h2>Mensajes (<a href=postMessage.php?toUser=$username>post a message</a>)</h2>");

	$query = "SELECT * FROM messages WHERE toUser='$username'";
	$result = $db_server->query($query);
	checkQueryResults($result);

	while($row = $result->fetch_row()) {
		//echo "<h3>From $row[0] on $row[3]</h3>";
		//echo "<h4>&nbsp;&nbsp;&nbsp;&nbsp;$row[2]</h4>";
		echo "<h4>From $row[0] on $row[3]</br>&nbsp;&nbsp;&nbsp;&nbsp;";
		if (strlen($row[2]) > $MAX_LINE_WIDTH) {

			$numRows = strlen($row[2]) / $MAX_LINE_WIDTH;

			for ($i = 0; ($i + 1) < $numRows; $i++) {
				$temp = substr($row[2], $i * $MAX_LINE_WIDTH, ($i + 1) * $MAX_LINE_WIDTH);
				echo "$temp</br>&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			$temp = substr($row[2], $numRows * $MAX_LINE_WIDTH, $strlen($row[2]));
			echo "$temp</h4>";
		
			//$i = 0;
			//while (($i + $MAX_LINE_WIDTH) < strlen($row[2])) {
				//echo "(Current i is $i)";
			//	$temp = substr($row[2], $i, $i + $MAX_LINE_WIDTH);
			//	echo "$temp</br>&nbsp;&nbsp;&nbsp;&nbsp;";
			//	$i += $MAX_LINE_WIDTH;
			//}
			//$temp = substr($row[2], $i - $MAX_LINE_WIDTH, strlen($row[2]));
			//echo "$temp</h4>";
		}
		else {
			echo "$row[2]</h4>";
		}
	}

	close($db_server);

?>

</body>
</html>
