<?php
	include './resources/config.php';
	header('Content-Type: application/json');
		
	$roll = $_POST['univRoll'];
	$dsn = 'mysql:host='.$config["db"]["student_details"]["host"].';dbname='.$config["db"]["student_details"]["dbname"].';';
	$user = $config["db"]["student_details"]["username"];
	$pass = $config["db"]["student_details"]["password"];
	$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES=>false,
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));

	$stmt = $db->prepare("Select * from details_student where `University Roll No`=?");
	$stmt->bindValue(1,$roll,PDO::PARAM_INT);
	try {
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		echo json_encode($result);
	}
	catch (PDOException $ex){
			return $ex;
	}
?>