<?php
	require './resources/config.php';

	$dsn = 'mysql:host='.$config["db"]["marks"]["host"].';dbname='.$config["db"]["marks"]["dbname"].';';
	$user = $config["db"]["marks"]["username"];
	$pass = $config["db"]["marks"]["password"];
	$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES=>false,
					PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
	$subjects = array();

	if( strpos(($_SERVER['REQUEST_URI']),'courses.php') !== false)
		return retrieveSubjectHeaders($_GET['sem']);
	else {
		$sem = $_POST["sem"];
		$univRoll = $_POST["univRoll"];
		echo (printMarksheet($univRoll));
	}

	//print_r (getSubjectHeader($db,$sem));
	
	//print_r (getMarks($db,$univRoll,$sem));

	/*if((isset($_POST["menu"]) && !empty($_POST["menu"]))
		echo json_encode(getSubjectHeader($db, $sem));
	else 
		echo "Get Error!!";*/

	function retrieveSubjectHeaders($sem){
		global $db;
		return getSubjectHeader($db,$sem);
	}
	
	

	function getSubjectHeader($db, $sem) {
		
		global $subjects;
		global $sem;
		
		$stmt = $db->prepare("SELECT * FROM `semwisesub_index` WHERE `Semester`=:sem;");
		$stmt->bindValue(':sem',$sem,PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cols = array_keys($row);
		$labCode = 1;
		$subCode = 1;
		
		for( $i = 1; $i < count($row); $i=$i+3 ) {
			
			if(empty($row[$cols[$i]])||empty($row[$cols[$i+1]]))
				continue;
			else {
				$subjects[$subCode] = array();
				$subjects[$subCode]['SubCode'] = $row[$cols[$i]];
				$subjects[$subCode]['SubName'] = $row[$cols[$i+1]];
				$subjects[$subCode]['SubCredit'] = $row[$cols[$i+2]];
				$subCode++;
			}

		}
		return $subjects;
	}
	   
	function getMarks($db, $univRoll, $sem) {
		
		global $subjects;
		$subjects = (getSubjectHeader($db,$sem));
		
		$stmt = $db->prepare("Select * from regular_sem".$sem." where `University Roll No`=:univRoll;");
		$stmt->bindValue(':univRoll',$univRoll,PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cols = array_keys($row);
		$subCode = 1;
		
		for ( $i = 2; $i < (count($row)-1); $i=$i+2) {
			if (empty($row[$cols[$i]])) {
				$subjects[$subCode][$cols[$i]] = "Data Unavailable!!";
				$subjects[$subCode][$cols[$i+1]] = "Data Unavailable!!";
			}				
			else {
				$subjects[$subCode][$cols[$i]] = $row[$cols[$i]];
				$subjects[$subCode][$cols[$i+1]] = $row[$cols[$i+1]];
			}
			$subCode++;
		}
		if (empty($row['SGPA'.$sem]))
			array_push($subjects, "Data Unavailable.");
		else
			array_push($subjects, $row['SGPA'.$sem]);
		
		return ($subjects);
		
	}
	
	function printMarksheet($univRoll) {
		global $db, $sem;
		$record = getMarks($db,$univRoll,$sem);
		
		echo "<table id='marksheet' class='table table-hover table-condensed'>
			<tr>
				<th>Subject Code</th>
				<th>Subject Offered</th>
				<th>Letter Grade</th>
				<th>Points</th>
				<th>Credit</th>
				<th>Credit Points</th>
			</tr>";
		
		for ( $i = 1; $i < count($record); $i++) {
			$cols = array_keys($record[$i]);
			echo "\n\t<tr>";
			for ( $j = 0; $j < count($record[$i]); $j++) {
				echo "<td>".$record[$i][$cols[$j]]."</td>";
			}
			if (empty($record[$i])||empty($record[$i][$cols[$j-1]]))
				echo "<td>Data Unavailable!!";
			else
				echo "<td>".($record[$i][$cols[$j-1]] * $record[$i]['SubCredit'])."</td></tr>";
		}
		echo "\n</table>";
		if(!($sem%2)) {
			$lastSem = getMarks($db,$univRoll,($sem-1));
			$lastSemSgpa = $lastSem[count($lastSem)];
			$thisSgpa = $record[$i];
			if (empty($lastsemSgpa)||empty($thisSgpa))
				echo "Data Unavailable!!";
			else {
				echo "<label>".($sem-1)." SGPA: ".$lastsemSgpa."</label>";
				echo "\t <label>$sem SGPA: ".$thisSgpa."</label>";
				echo "\t <label>YGPA: ".(($lastsemSgpa+$thisSgpa)/2)."</label>";
			}
			
		}
		else
			echo "<div class='bs-example'>".($sem)." SGPA: ".$record[$i]."</div>";
		
	}
	
?>