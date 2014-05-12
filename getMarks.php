<?php
	require_once './resources/config.php';
	$subjects = array();

	if( (strpos(($_SERVER['REQUEST_URI']),'courses.php') !== false) || (strpos(($_SERVER['REQUEST_URI']),'attendanceSheet.php') !== false) )
		return retrieveSubjectHeaders("marks",8/*$_POST['sem']*/);
	else {
		if((isset($_POST["semester"]) && !empty($_POST["semester"]))) {
			$sem = $_POST["semester"];
			$univRoll = $_COOKIE["univRoll"];
			echo (printMarksheet($univRoll));
		}	
	}
	

	function retrieveSubjectHeaders($db, $sem){
		return getSubjectHeader($db,$sem);
	}
	
	function setDb ($dbase) {
		global $config;
		$dsn = 'mysql:host='.$config["db"][$dbase]["host"].';dbname='.$config["db"][$dbase]["dbname"].';';
		$user = $config["db"][$dbase]["username"];
		$pass = $config["db"][$dbase]["password"];
		$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES=>false,
						PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
						PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
		return $db;
	}

	function getSubjectHeader($db, $sem) {
		
		global $subjects;
		global $sem;
		$db = setDb("marks");
		$stmt = $db->prepare("SELECT * FROM `semwisesub_index` WHERE `Semester`=:sem;");
		$stmt->bindValue(':sem',$sem,PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cols = array_keys($row);
		$labCode = 1;
		$subCode = 1;
		
		for( $i = 1, $in = 1; $i < count($row); $i=$i+3, $in++ ) {
			
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
		$resuts = array();
		$subjects = (getSubjectHeader($db,$sem));
		
		$stmt = $db->prepare("Select * from regular_sem".$sem." where `University Roll No`=:univRoll;");
		$stmt->bindValue(':univRoll',$univRoll,PDO::PARAM_INT);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
    		$results[] = $row;
		}
		$cols = array_keys($results);
		
		/*print_r ($results);
		print "<br><br>";*/
		/**print_r ($subjects);
		print "<br><br>";**/
		
		$table = [];
		$i=1;
		foreach ($subjects as $subject) {
			$rec = [];
			$rec['SubCode'] = $subject['SubCode'];
			$rec['SubName'] = $subject['SubName'];
			$rec['SubGrade'] = ( empty ( $results[0]['SubCode'.$i] ) ) ? "Data Unavailable" : ( $results[0]['SubCode'.$i] );
			$rec['SubPoint'] = ( empty ( $results[0]['SubCode'.$i.'_Point'] ) )? "Data Unavailable!!" : ( $results[0]['SubCode'.$i.'_Point'] );
			$rec['SubCredit'] = $subject['SubCredit'];
			$rec['SubCrdtPnt'] = ( empty ( $results[0]['SubCode'.$i.'_Point']) ) ? "Data Unavailable!!" : ( $rec['SubPoint'] * $rec['SubCredit'] );
			/*print_r ($rec);
			print "<br>";*/
			array_push ($table,$rec);
			$i++;
		}
		$table['SGPA'] = $results[0]['SGPA'.$sem];
		//print_r ($table);
		
		return ($table);
		
	}
	
	function printMarksheet($univRoll) {
		global $sem;
		$db = setDb("marks");
		$record = getMarks($db,$univRoll,$sem);
		$sumCreditPoint = 0;
		$sumCredits = 0;
		echo "<table id='marksheet' class='table table-hover table-condensed'>
			<tr>
				<th>Subject Code</th>
				<th>Subject Offered</th>
				<th>Letter Grade</th>
				<th>Points</th>
				<th>Credit</th>
				<th>Credit Points</th>
			</tr>";
		
		for ( $i =0 ; $i < (count($record)-1); $i++) {
			echo "<tr><td>".$record[$i]['SubCode']."</td>";
			echo "<td>".$record[$i]['SubName']."</td>";
			echo "<td>".$record[$i]['SubGrade']."</td>";
			echo "<td>".$record[$i]['SubPoint']."</td>";
			echo "<td>".$record[$i]['SubCredit']."</td>";
			$sumCredits += $record[$i]['SubCredit'];
			echo "<td>".$record[$i]['SubCrdtPnt']."</td></tr>";
			$sumCreditPoint += $record[$i]['SubCrdtPnt'];
		}
		echo "\n</table>";
	
		$thisSemSgpa = $record['SGPA'];
		
		if(!($sem%2)) {
			//even Semester
			$lastSem = getMarks($db,$univRoll,($sem-1));
			$lastSemSgpa = $lastSem['SGPA'];
			
			if (is_nan($lastSemSgpa) || empty($lastSemSgpa)) {
				echo "<label> SGPA " . ($sem-1) . ": Data Unavailable!!</label><br>";
				if (is_nan($thisSemSgpa) || empty($thisSemSgpa))
					echo "<label> SGPA " . ($sem) . ": Data Unavailable!!</label><br>";
				else
					echo "<label> SGPA " . ($sem) . ": " . $thisSemSgpa . "</label><br>";
				
			}
			elseif (is_nan($thisSemSgpa) || empty($thisSemSgpa)) {
				echo "<label> SGPA " . ($sem) . ": Data Unavailable!!</label><br>";
				echo "<label> YGPA " . ($sem/2) . ": Data Unavailable!!</label><br>";
			}
			else {
				echo "<label> SGPA " . ($sem-1) . ": " . $lastSemSgpa ."</label><br>";
				echo "<label> SGPA " . ($sem) . ": " . $thisSemSgpa ."</label><br>";
				echo "<label> YGPA " . ($sem/2) . ": " . ($lastSemSgpa+$thisSemSgpa)/2 ."</label><br>";
			}
		}
		else{
			//odd semester
			if ( is_nan ($thisSemSgpa) || empty($thisSemSgpa) ) 
				echo "<label> SGPA " . $sem . ": Data Unavailable!!</label><br>";
			else
				echo "<label> SGPA " . $sem . ": " . $thisSemSgpa . "</label><br>";
		}
		
	}
	
?>