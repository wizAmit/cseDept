<?php
	$dsn = 'mysql:host=localhost;dbname=attendance';
	$user='root';
	$pass='project';
	$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES=>false,
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
	for ($x=11500113073; $x<11500113124; $x++){
		$sql = $db->prepare("ALTER TABLE `da_sem2` ADD `".$x."` BOOLEAN NOT NULL DEFAULT TRUE;");
		$sql->execute();
		echo $x." is added.";
	} 
	echo 'FINISHED.';
?>