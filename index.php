<?php
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	if ((strpos($useragent,"Android") || strpos($useragent,"Mobi"))!== false)	{
		echo 'Coming soon to your device. Keep Watching this space.';
	}
	else	{
		//header('Location: /home.html');
		echo 'Hello World!!';
		echo 'from CSE Dept';
	}
?>
