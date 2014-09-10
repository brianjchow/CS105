<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Search</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<body>

<?php

	// search ALL records in EACH table for substrings
	// figure out how to strip the extensions in each picTitle OR add an unqualified picTitle field in pictures table

	$debug = false;

	session_start();
	require "class_lib.php";

	$username = $_SESSION['username'];
	printToolbar($username, false);

	$search = $_POST['search'];

	echo "</br>";

	echo "<h1>Search Results</h1>";

	echo "<h3>Searched for: \"$search\"</h3>";

	$db_server = connect();

	$numResults = 0;

	print("<hr />");
	echo "<h3>Users</h3>";
	$oldNumResults = $numResults;
	$numResults = searchUsers($search, $numResults, $db_server);
	if ($oldNumResults == $numResults) {
		echo "&nbsp&nbsp&nbsp&nbspNo results found.";
	}
	echo "</br>";

	print("<hr />");
	echo "<h3>Albums</h3>";
	$oldNumResults = $numResults;
	$numResults = searchAlbums($search, $numResults, $db_server);
	if ($oldNumResults == $numResults) {
		echo "&nbsp&nbsp&nbsp&nbspNo results found.";
	}		
	echo "</br>";

	print("<hr />");
	echo "<h3>Pictures</h3>";
	$oldNumResults = $numResults;
	$numResults = searchPictures($search, $numResults, $db_server);
	if ($oldNumResults == $numResults) {
		echo "&nbsp&nbsp&nbsp&nbspNo results found.";
	}
	echo "</br>";

	print("<hr />");
	echo "<h3>General matches in page</h3>";
	$oldNumResults = $numResults;
	$users = array();
	$users = searchGeneral($search, $users, $db_server);
	$numResults += count($users);
	// print users
	foreach($users as $user) {
		$temp = "profile.php?user=" . $user;
		echo "&nbsp&nbsp&nbsp&nbsp- <a href=$temp>$user</a></br>";
	}
	if ($oldNumResults == $numResults) {
		echo "&nbsp&nbsp&nbsp&nbspNo results found.";
	}
	echo "</br>";	

	echo "<h3>$numResults match(es) returned.<h3>"; 

	function searchUsers($search, $numResults, $db_server) {
		$query = "SELECT * FROM users";
		$result = $db_server->query($query);
		checkQueryResults($result);

		while ($row = $result->fetch_row()) {
			$matchResult = strripos($row[0], $search);
			if ($matchResult !== false) {
				$numResults++;
				$temp = "profile.php?user=" . $row[0];
				echo "&nbsp&nbsp&nbsp&nbsp- <a href=$temp>$row[0]</a></br>";
			}
		}
		return $numResults;
	}

	function searchAlbums($search, $numResults, $db_server) {
		$query = "SELECT * FROM albums";
		$result = $db_server->query($query);
		checkQueryResults($result);

		while ($row = $result->fetch_row()) {
			$matchResult = strripos($row[1], $search);
			if ($matchResult !== false) {
				$numResults++;
				$temp = "album.php?user=" . $row[0] . "&albumTitle=" . $row[1];
				$userURL = "profile.php?user=" . $row[0];
				echo "&nbsp&nbsp&nbsp&nbsp- <a href=$temp>$row[1]</a> (from user <a href=$userURL>$row[0]</a>)</br>";
			}
		}
		return $numResults;
	}

	function searchPictures($search, $numResults, $db_server) {
		$query = "SELECT * FROM pictures";
		$result = $db_server->query($query);
		checkQueryResults($result);

		while ($row = $result->fetch_row()) {
			$matchResult = strripos($row[3], $search);
			if ($matchResult !== false) {
				$numResults++;
				$temp = "view.php?user=" . $row[0] . "&albumTitle=" . $row[1] . "&picPath=" . $row[0] . "/" . $row[1] . "/" . $row[3];
				$userURL = "profile.php?user=" . $row[0];
				$albumURL = "album.php?user=" . $row[0] . "&albumTitle=" . $row[1];
				$unqualifiedPicName = substr($row[3], 0, strripos($row[3], '.'));		// strripos finds last occurrence of '.' in $row[3]
				echo "&nbsp&nbsp&nbsp&nbsp- <a href=$temp>$unqualifiedPicName</a> (from user <a href=$userURL>$row[0]</a>, in album <a href=$albumURL>$row[1]</a>)</br>";
			}
		}
		return $numResults;
	}

	function searchGeneral($search, $users, $db_server) {

		$query = "SELECT * FROM profiles";
		$result = $db_server->query($query);
		checkQueryResults($result);
		while ($row = $result->fetch_row()) {
			$matchFact1 = strpos($row[1], $search);
			$matchFact2 = strpos($row[2], $search);
			$matchFact3 = strpos($row[3], $search);
			if ($matchFact1 !== false || $matchFact2 !== false || $matchFact3 !== false) {
				$users[] = $row[0];
			}
		}

		$query = "SELECT * FROM messages";
		$result = $db_server->query($query);
		checkQueryResults($result);
		while ($row = $result->fetch_row()) {
			$matchResult = strpos($messages[2], $search);
			$alreadyExists = array_search($search, $users);
			if ($alreadyExists === false) {
				$users[] = $row[1];
			}
		}
		return $users;
	}

	close($db_server);	

?>

</body>
</html>
