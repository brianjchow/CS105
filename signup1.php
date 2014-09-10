<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Account Registration</title>
<link rel="stylesheet" type="text/css" href="SiteStyle.css" />
<meta http-equiv="Content-Type"
	content="text/html; charset = ISO-8859-1" />
</head>

<script language = "javascript">
	// credits to http://www.smartwebby.com/DHTML/textbox_characters_counter.asp
	
	var MAX_FACT_LENGTH = <?php echo $MAX_FACT_LENGTH; ?>;
	var bName = navigator.appName;

	function taCount(taObj, cnt) {
		objCnt = createObject(cnt);
		objVal = taObj.value;
		//if (objVal.length > max) {
		//	objVal = objVal.substring(0, max);
		//}
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
	$userLoggedIn = printToolbar($username, false);

	echo "<h1>Gallery Registration</h1>";

	if ($userLoggedIn) {
		echo "Log out first before creating a new account.</br>";
	}
	else {
		?>

		<form action="signup2.php" enctype="multipart/form-data" method="POST">
			Username: <input type="text" name="username"><br>
			Password*: <input type="password" name="password1"><br>
			Re-enter password: <input type="password" name="password2"></br></br>

			Any fields below left blank will remain unchanged.

			<p>
				<label for="file">Choose a profile picture:</label>
				<input id="file" type="file" name="file">
				</br>
				Supported file extensions: .jpg, .gif, .png, .tif
			</p>

			Enter 3 facts about yourself (limit 250 characters each):</br></br>
				Fact 1: </br><textarea onKeyPress="return taLimit(this)" onKeyUp="return taCount(this, 'fact1Count')" 
							name="fact1" cols="60" rows="3"></textarea>
				</br>You have <B><SPAN id=fact1Count><?php echo $MAX_FACT_LENGTH; ?></SPAN></B> characters remaining for Fact 1.</br></br>
				Fact 2: </br><textarea onKeyPress="return taLimit(this)" onKeyUp="return taCount(this, 'fact2Count')" 
							name="fact2" cols="60" rows="3"></textarea>
				</br>You have <B><SPAN id=fact2Count><?php echo $MAX_FACT_LENGTH; ?></SPAN></B> characters remaining for Fact 2.</br></br>
				Fact 3: </br><textarea onKeyPress="return taLimit(this)" onKeyUp="return taCount(this, 'fact3Count')" 
							name="fact3" cols="60" rows="3"></textarea>
				</br>You have <B><SPAN id=fact3Count><?php echo $MAX_FACT_LENGTH; ?></SPAN></B> characters remaining for Fact 3.</br></br>

			<p>*must be at least 6 characters long and contain at least one uppercase letter and one symbol (~, #, $, %, ^, &, *, +, -, :, ;, !, ?, etc)</p>
		
			<input type="submit" value="Submit">
		</form>
		
		<?php
	}

?>

</body>
</html>
