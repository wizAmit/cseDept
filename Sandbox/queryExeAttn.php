<?php
	$dsn = 'mysql:host=localhost;dbname=student_details';
	//echo $dsn;

	header('Content-Type: application/json');
	$user='root';
	$pass='project';
	$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES=>false,
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
	/*
		Portion of query processing used for attendance page 	
																*/

	/*echo "\n\n:: Data received via POST ::\n\n";
	print_r($_POST);*/
	$sem = $_POST['sem'];
	$section = $_POST['sec'];
	//print ($sem . " " . $section);
	$calculated_Clg_Roll = intval((date("Y") - intval($sem/2))%1000) + 2;
	$stmt = $db->prepare("Select `University Roll No` from details_student where Sec = '" . $section . "' and CollegeRoll like ?;");
	//echo $calculated_Clg_Roll;
	$stmt->bindValue(1,"$calculated_Clg_Roll%",PDO::PARAM_STR);
	$rolls = array();
	try{
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_NUM);
		/*foreach ($result as $roll){
			echo $roll[0] . "\n";
			array_push($rolls,$newRoll);
		}*/
//		print_r $rolls;
		print json_encode($result);
	}
	catch (PDOException $ex){
		echo $ex;
	}
?>