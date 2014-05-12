<?php 
	include './resources/config.php';
//	print_r ($_POST);
	$dsn = 'mysql:host='.$config["db"]["student_details"]["host"].';dbname='.$config["db"]["student_details"]["dbname"].';';
	$user = $config["db"]["student_details"]["username"];
	$pass = $config["db"]["student_details"]["password"];
	$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES=>false,
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));

	$stmt = $db->prepare("UPDATE details_student SET a = ? where `University Roll No`=?");
?>