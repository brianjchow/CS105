<?php

$phaseNum = 4;

$src = "/u/bc23784/Desktop/p" . $phaseNum . "/initialize.sql";
$dst = "/u/z/users/cs105/bc23784/p" . $phaseNum;

if (!chmod($src, 0777)) {
	echo "Failed to chmod 777 - fuck you";
}
else {
	$dir = $src;
	closedir(opendir($dir));
	rCopy($src, $dst);
}

function rCopy($src, $dst) {

	$dir = opendir($src);
	@mkdir($dst, 0777);
	while (($file = readdir($dir)) !== false) {
		if (($file != '.') && ($file != '..')) {
			if (is_dir($src . "/" . $file)) {
				rCopy($src . "/" . $file, $dst . "/" . $file);
			}
			else {
				copy($src . "/" . $file, $dst . "/" . $file);
			}
		}
	}
	closedir($dir);
}

?>
