<?php
	include 'queryExeAttn.php';

	$sem = $_POST['sem'];
	$secAbsent = $_POST['sec_Absent'];
	$subCode = $_POST["subCode"];
	$massBunk = $_POST["massbunk"];

	if ($secAbsent=="none")
		$both = 1;
	else
		$both = 0;

	$rolls = getRollNo($sem, $secAbsent, $both);

	$rec_db = [];
	$rec_fac = [];
	
	foreach ($rolls as $roll)
		foreach ($roll as $t)
			$rec_db[$t]=9;
	
	//data that is comming from the form submitted.
	$data = json_decode($_POST['value']);
	//print_r ($rec_db);
	
	foreach ($data as $stdOb) {
		if($massBunk)
		$rec_fac[($stdOb->rollNo)]=8;
		else
		$rec_fac[($stdOb->rollNo)]=($stdOb->present);
	}
	//print_r ($rec_fac);
	
	$data_insert = [];
	$data_insert = array_merge($rec_db,$rec_fac);
	ksort($data_insert);
	//print_r ($data_insert);
	
	$dateTime = $_POST['time'];
	
	print (uploadAttendance(8,'CS803', $data_insert, $dateTime));

	function uploadAttendance($sem, $subCode, $data_ins, $date_ins){
		
		global $config;

		$field = "";
		$vals = "";
		//return $data_ins;

		$rolls = array_keys($data_ins);
		for($i=0;$i<count($rolls);$i++)
			$field = ( $i == (count($rolls)-1) )?($field."`$rolls[$i]`"):($field."`$rolls[$i]`".',');

		$values = array_values($data_ins);
		for($i=0;$i<count($values);$i++)
			$vals = ( $i == (count($values)-1) ) ? ($vals.$values[$i]) : ( $vals.$values[$i].',' );
		
		$dsn = 'mysql:host='.$config["db"]["attendance"]["host"].';dbname='.$config["db"]["attendance"]["dbname"].';';
		$user = $config["db"]["attendance"]["username"];
		$pass = $config["db"]["attendance"]["password"];
		$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES=>false,
				PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
				PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
		
		try {
			$stmt = $db->exec("INSERT INTO `da_sem$sem` (`DateTime`,`SubCode`,$field) VALUES ('$date_ins','$subCode',$vals)");
			return $stmt;
		}
		catch(PDOException $ex) {
			echo $ex;
		}
		
	}
?>