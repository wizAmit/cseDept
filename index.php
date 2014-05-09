<?php
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	if ((strpos($useragent,"Android") || strpos($useragent,"Mobi"))!== false)	{
		echo 'Coming soon to your device. Keep Watching this space.';
	}
	else	{
		header('Location: ./signup.php');
		//echo 'Hello World!!';
	}
	
	include "./header.php";
?>






<?php
	include "./footer.php";
?>