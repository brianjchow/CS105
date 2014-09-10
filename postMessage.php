<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Post Message</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<script language = "javascript">
	// credits to http://www.smartwebby.com/DHTML/textbox_characters_counter.asp
	
	var	MAX_MESSAGE_LENGTH = <?php echo $MAX_MESSAGE_LENGTH; ?>;
	var bName = navigator.appName;

	function taCount(taObj, cnt) {
		objCnt = createObject(cnt);
		objVal = taObj.value;
		//if (objVal.length > MAX_MESSAGE_LENGTH) {
			//objVal = objVal.substring(0, MAX_MESSAGE_LENGTH);
		//}
		if (objCnt) {
			if (bName == "Netscape") {
				objCnt.textContent = MAX_MESSAGE_LENGTH - objVal.length;
			}
			else {
				objCnt.innerText = MAX_MESSAGE_LENGTH - objVal.length;
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

	function process() {

		var toUser = document.getElementsByName('toUser')[0].value;

		var request;
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

		var msg = document.getElementById("message");
		var msgData = encodeURIComponent(msg.value);
		
		var formData = "toUser=" + toUser + "&" + msg.name + "=" + msgData;	// "name=value"
		//var formData = document.getElementById("postMessage").serialize();
		//var formData = new FormData(document.getElementById("postMessage"));		// apparently unsupported by Z
		//var formData = new FormData(document.forms.namedItem("postMessage"));	

		request.open('POST', 'postMessageHandler.php', true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.send(formData);		

		var oOutput = document.getElementById("output");
		request.onreadystatechange = function() {
			if (request.status !== 200) {
				alert("Error " + request.status + "; please try again.");
				//oOutput.innerHTML = "Error " + request.status + "; please try again.";
			}
			else if (msgData.length <= 0 && request.readyState === 4) {
				alert("Yo dawg you gots to enter a message");
			}
			else if (msg.length > MAX_MESSAGE_LENGTH && request.readyState === 4) {			// will handle worst case scenario when all chars need to be encoded
				alert("Not sure if illiterate or just stupid...");
			}
			else if (request.readyState === 4 && request.status === 200) {
				alert("Message posted! Click OK to continue.");
				self.location = "profile.php?user=" + toUser;
				//oOutput.innerHTML = "Message posted! Response text is " + request.responseText + ".";
			}
		}	
		return false;
	}

</script>

<body>

<?php

	session_start();

	require "class_lib.php";

	// get op from session var

	$op = $_SESSION['username'];
	printToolbar($op, false);

	echo "</br>";

	if (!isEmptyString($op)) {

?>

	<!--<form id="postMessage" action="postMessageHandler.php" enctype="multipart/form-data" method="POST">-->
	<form id = "postMessage" name="postMessage" method="POST" onsubmit="process(); return false;">
		Enter a message (<?php echo $MAX_MESSAGE_LENGTH; ?> character limit):</br></br>

		<textarea onKeyPress="return taLimit(this)" onKeyUp="return taCount(this, 'counter')" id="message" name="message" value="msgVal" cols="60" rows="7"></textarea></br>

		<input type = "hidden" name = "toUser" value = "<?php echo $_GET['toUser']; ?>">

		</br>You have <B><SPAN id=counter><?php echo $MAX_MESSAGE_LENGTH; ?></SPAN></B> characters remaining.</br></br>

    	<input type="submit" value="Submit">
	</form>
	</br>
	<div id="output"></div>

<?php
		
	}
	else {
		echo "You must be logged in to do that. Click <a href=login.php>here</a> to log in. Click <a href=signup1.php>here</a> 
			to sign up for an account.</br>";
	}

?>

</body>
</html>
