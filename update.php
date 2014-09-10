<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Update Profile</title>
<link rel="stylesheet" type="text/css" href="siteStyle.css" />
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

	$sessionUsername = $_SESSION['username'];
	$userLoggedIn = printToolbar($sessionUsername, false);

	echo "<h1>Update Profile</br></h1>";

	if (!$userLoggedIn) {
		echo "You must be logged in to do that. Click <a href=login.php>here</a> to log in. Click <a href=signup1.php>here</a> 
			to sign up for an account.</br>";
	}
	else {

		$db_server = connect();

		$query = "SELECT * FROM profiles WHERE username=" . "'" . $_GET['user'] . "'";
		$result = $db_server->query($query);
		checkQueryResults($result);

		$row = $result->fetch_row();
	
		?>
			<form id="Upload" action="updateHandler.php" enctype="multipart/form-data" method="POST">

				Fields left blank will remain unchanged.</br>
	
				<p>
					</br>
					<label for="file">Choose a profile picture:</label>
					<input id="file" type="file" name="file">
					</br>
					Supported file extensions: .jpg, .gif, .png, .tif
				</p>

				Fact 1*: </br><textarea onKeyPress="return taLimit(this)" onKeyUp="return taCount(this, 'fact1Count')" 
							name="fact1" cols="60" rows="3"><?php echo $row[1]; ?></textarea>
				</br>You have <B><SPAN id=fact1Count><?php echo ($MAX_FACT_LENGTH - strlen($row[1])); ?></SPAN></B> characters remaining for Fact 1.</br></br>
				Fact 2*: </br><textarea onKeyPress="return taLimit(this)" onKeyUp="return taCount(this, 'fact2Count')" 
							name="fact2" cols="60" rows="3"><?php echo $row[2]; ?></textarea>
				</br>You have <B><SPAN id=fact2Count><?php echo ($MAX_FACT_LENGTH - strlen($row[2])); ?></SPAN></B> characters remaining for Fact 2.</br></br>
				Fact 3*: </br><textarea onKeyPress="return taLimit(this)" onKeyUp="return taCount(this, 'fact3Count')" 
							name="fact3" cols="60" rows="3"><?php echo $row[3]; ?></textarea>
				</br>You have <B><SPAN id=fact3Count><?php echo ($MAX_FACT_LENGTH - strlen($row[3])); ?></SPAN></B> characters remaining for Fact 3.</br></br>

				* <?php echo $MAX_FACT_LENGTH; ?> character limit</br></br>

				<input type = "hidden" name = "username" value = "<?php echo $_GET['user']; ?>">
		
				<input type="submit" value="Submit">
			
			</form>
			
		<?php

		close($db_server);		

	}	



?>

</body>
</html>
