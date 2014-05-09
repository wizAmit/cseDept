<?php
	require '../resources/config.php';
	if(!($_SERVER['REQUEST_URI'] == $_SERVER['SERVER_NAME'].'/Sandbox/uploadAttn.php'))
		header('Content-Type: application/json');

	$sem;
	$section;

	if((isset($_POST["sem"]) && isset($_POST["sec"])) && !empty($_POST["sem"]) && !empty($_POST["sec"])) {
		global $sem; 
		global $section;
		$sem = $_POST['sem'];
		$section = $_POST['sec'];
		if($section == "AB")
		echo json_encode(getRollNo($sem, $section, 1));
		else
			echo json_encode(getRollNo($sem, $section, 0));
			
	}
	/*else if (isset($_POST["value"]) && !empty($_POST["value"]))
		uploadAttendance(8,'A',json_decode($_POST["value"]));*/
	else
		$config["urls"]["errorUrl"];

	//echo json_encode(getRollNo($sem,$section,false));


	function getRollNo($sem, $section, $both) {
	
		global $config;
		
		$dsn = 'mysql:host='.$config["db"]["student_details"]["host"].';dbname='.$config["db"]["student_details"]["dbname"].';';
		$user = $config["db"]["student_details"]["username"];
		$pass = $config["db"]["student_details"]["password"];
		$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES=>false,
				PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
		
		$calculated_Clg_Roll = intval((date("Y") - intval($sem/2))%1000) + 2;
		
		if ($both)
			$stmt = $db->prepare("Select `University Roll No` from details_student where CollegeRoll like ?;");
		else 
			$stmt = $db->prepare("Select `University Roll No` from details_student where Sec like '" . $section . "' and CollegeRoll like ?;");
		
		$stmt->bindValue(1,"$calculated_Clg_Roll%",PDO::PARAM_STR);
		
		try{
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_NUM);
			//print_r $rolls;
			sort($result);
			return $result;
		}
		catch (PDOException $ex){
			return $ex;
		}
	}

?>