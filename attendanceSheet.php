<?php
	
require_once './getMarks.php';
	
	$univRoll = $_COOKIE['univRoll'];
	$sem = $_COOKIE['sem'];
	
	$db = setDb("attendance");

	$subCodes = retrieveSubjectHeaders($db, $sem);
	/*$dsn = 'mysql:host='.$config["db"]["attendance"]["host"].';dbname='.$config["db"]["attendance"]["dbname"].';';
	$user = $config["db"]["attendance"]["username"];
	$pass = $config["db"]["attendance"]["password"];
	$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_EMULATE_PREPARES=>false,
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));*/

	return (printAttendanceSheet($db, $subCodes));

	function printAttendanceSheet($db, $subCodes){
		global $univRoll, $sem;
		echo ("<div class='table-responsive'>
				<table class='table table-striped table-hover'>
					<tr>
						<th>Subject</th>
						<th>Attendance %</th>
					</tr>");
		foreach ($subCodes as $key => $value) {
			$classAttended;
			$classHeld;
			$attnPercent;
			$style;
		
			$stmt = $db->prepare("SELECT count(`SubCode`) FROM `da_sem".$sem."` WHERE ((`SubCode`= ?) AND ((`".$univRoll."`='1') OR (`".$univRoll."`='8') OR (`".$univRoll."`='0')))");
			$stmt1 = $db->prepare("SELECT count(`SubCode`) FROM `da_sem".$sem."` WHERE ((`SubCode`= ?) AND (`".$univRoll."`='1'))");
		
			echo ("<tr>
					<td>".$value['SubCode']."</td>
					<td>");
		
			$stmt->bindValue(1, substr($value['SubCode'],0,5), PDO::PARAM_STR);
			$stmt1->bindValue(1, substr($value['SubCode'],0,5), PDO::PARAM_STR);
			try {
				$stmt->execute();
				$classHeld = $stmt->fetch(PDO::FETCH_NUM);
				$stmt1->execute();
				$classAttended = $stmt1->fetch(PDO::FETCH_NUM);
				if ($classHeld[0] == 0)
					$attnPercent = 100;
				else
					$attnPercent = (($classAttended[0]/$classHeld[0])*100);
				if ($attnPercent > 80)
					$style = 'success';
				else if ($attnPercent > 60)
					$style = 'warning';
				else
					$style = 'danger';
		
				echo ($attnPercent . "</td>
				</tr>");
				/*echo ("<div class='progress progress-striped active'>
  					<div class='progress-bar progress-bar-$style' role='progressbar' aria-valuenow='".$attnPercent."' aria-valuemin='0' aria-valuemax='100' style='width: 40%'>
    					<span class='sr-only'>".$attnPercent." ($style)</span>
  					</div>
				</div></td>");*/
			}
			catch (PDOException $ex){
					return $ex;
			}
		}
		echo ("</table>
		</div>");
	}
?>