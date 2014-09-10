<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Create a New Album</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<script language = "javascript">
	// credits to http://www.smartwebby.com/DHTML/textbox_characters_counter.asp
	
	//max = 250;
	var MAX_FACT_LENGTH = <?php echo $MAX_FACT_LENGTH; ?>;
	var bName = navigator.appName;

	function taCount(taObj, cnt) {
		objCnt = createObject(cnt);
		objVal = taObj.value;
		if (objVal.length > MAX_FACT_LENGTH) {
			objVal = objVal.substring(0, max);
		}
		if (objCnt) {
			if (bName == "Netscape") {
				objCnt.textContent = MAX_FACT_LENGTH - objVal.length;
			}
			else {
				objCnt.innerText = MAX_FACT_LENGTH - objVal.length;
			}
		}
		return true;
	}

	function createObject(objId) {
		if (document.getElementById) {
			return document.getElementById(objId);
		}
		else if (document.layers) {
			return eval("document." + objId);
		}
		else if (document.all) {
			return eval("document.all." + objId);
		}
		else {
			return eval("document." + objId);
		}
	}
</script>

<body>

<?php

	session_start();

	require "class_lib.php";

	$username = $_SESSION['username'];
	$userLoggedIn =	printToolbar($username, false);

	echo "<h1>Create an album</h1>";

	if (!$userLoggedIn) {
		echo "You must be logged in to do that. Click <a href=login.php>here</a> to log in. Click <a href=signup1.php>here</a> 
			to sign up for an account.</br>";
	}
	else {

		?>

		<form id="NewAlbum" action="newalbum2.php" enctype="multipart/form-data" method="POST">
		     
			Album title*: <input type="text" name="albumTitle"><br>

			</br>* limit 30 characters</br>

			<p>
		        <input id="submit" type="submit" name="submit" value="Submit"> 
		    </p> 
		 
		</form>

		<?php
		
	}
	
?>

</body>
</html>
