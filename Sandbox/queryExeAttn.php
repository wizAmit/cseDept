<?php
	$dsn = 'mysql:host=localhost:3306;dbname=student_details';
	//echo $dsn;

	$user='root';
	$pass='project';
	$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES=>false,
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
	/*$search = $_GET['univRoll'];
	$list = $_GET['section']
	$stmt = $db->prepare("SELECT * from details_student where `University Roll No` like ?");
	$stmt->bindValue(1,"$search%",PDO::PARAM_STR);
	try{
		
		$stmt->execute();
		$num = $stmt->rowCount();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo (json_encode($results));
		if($num == 1)
			return json_encode($results);
		else
			return "No Such Data Found. Contact CS Dept.";
		
	} catch(PDOException $ex){
		echo $ex;
	}

	$stmt = $db->prepare("Select `University Roll No` from details_student where `Sec` like ?");
	$stmt->bindValue(1,"$list%",PDO::PARAM_STR);
	try{
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::ASSOC);
		return json_encode($results);
	} catxh(PDOException $ex) {
		echo $ex;
	}*/


	/*
		Portion of query processing used for attendance page */

	echo "\n\n:: Data received via POST ::\n\n";
	print_r($_POST);
	$sem = $_POST['sem'];
	$section = $_POST['sec'];
	//print ($sem . " " . $section);
	$calculated_Clg_Roll = intval((date("Y") - intval($sem/2))%1000) + 2;
	$stmt = $db->prepare("Select `University Roll No` from details_student where Sec = ? and CollegeRoll like " + $calculated_Clg_Roll + ";");
	$stmt->bindValue(1,"$section",PDO::PARAM_STR);
	try{
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_NUM);
		//echo '<div>'. json_encode($results) .'</div>';
		return json_encode($result);
	}
	catch (PDOException $ex){
		echo $ex;
	}
	return 1;
?>