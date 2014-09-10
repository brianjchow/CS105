<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Home</title>
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

	/*
	$userLoggedIn = printToolbar($username, false);

	if ($userLoggedIn) {
		echo "<h1>Welcome back, " . $username . "!</h1>";
	}
	else {
		echo "<h1>Welcome!</h1>";
	}
	*/

	$id = $_GET['id'];

	if (isset($_GET['id']) && !isset($_SESSION['username'])) {
		echo "<h1>See you next time, " . $id . "!</h1>";
	}
	else if (isset($_SESSION['username'])) {
		echo "<h1>Welcome back, " . $username . "!</h1>";
	}
	else {
		echo "<h1>Welcome!</h1>";
	}

	echo "<h4>List of registered users:</h4>";

	$db_server = connect();

	// get list of registered users and print
	$query = "SELECT * FROM users;";
	$result = $db_server->query($query);
	checkQueryResults($result);
	while ($row = $result->fetch_row()) {
		$temp = "profile.php?user=" . $row[0];
		echo "<a href=$temp>$row[0]</a></br>";
	}

	echo "</br></br>";
	$picPath = "bobbytables.jpg";
	echo "<div align = 'center'><table><tr><td><img src=bobbytables.jpg/></br></td></tr></table></div>";

	close($db_server);

?>

</body>
</html>

