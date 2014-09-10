<?php

	// all input checking shifted to JS on postMessage.php

	session_start();

	require "class_lib.php";

	$op = $_SESSION['username'];

	$db_server = connect();
	
	$toUser = $_POST['toUser'];
	$dateTime = date('m-d-Y H:i:s');
	$message = $_POST['message'];

	$query = "SELECT * FROM messages";
	$result = $db_server->query($query);
	checkQueryResults($result);

	$query = "INSERT INTO messages(op, toUser, message, dateTime) 
		VALUES('" . $op . "', '" . $_POST['toUser'] . "', '" . $_POST['message'] . "', '" . $dateTime . "');";
	$result = $db_server->query($query);
	checkQueryResults($result);

	close($db_server);

?>

