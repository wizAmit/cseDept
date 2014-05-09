<?php
	//include './header.php';
	include './getMarks.php';
	$sem = $_GET['sem'];
	$subCodes = retrieveSubjectHeaders($sem);
	/*foreach ($subCodes as $subject){
		print $subject['SubCode'] . " " . $subject['SubName'] . "<br>";
	}*/
	$i=0;
	$blogs = simplexml_load_file((__DIR__).'/resources/sem'.$sem.'Blog.xml');
	/*foreach ($blogs->SubCode as $subCode) {
		printf("SubCode id: %s, entry date: %s title: %s desc: %s<br>",
			   $subCode["id"],
			   $subCode->entry['date'],
			   $subCode->entry->title,
			   $subCode->entry->description	
		);
	}*/

	echo "	<div class='table-responsive'>
			<img src='./img/rss.gif' width='36' height='14'>
			<table class='table table-hover table-condensed'>
			<tr>
				<th>SUBJECT CODE</th>
				<th>Latest Happening</th>
			</tr>";
	foreach ($subCodes as $subject) {
		echo "<tr><td>".$subject['SubCode']."</td>";
		foreach($blogs->SubCode as $subCode){
			if(((string)$subCode['id'])===$subject['SubCode']) {
				echo "<td>".$subCode->entry['date'].": <a href='#'>".$subCode->entry->title."</a></td></tr>";
				break;
			}
		}
	}
	echo "</table></div>";
	/*".printBLogDesc((string)($subCode->entry->description))."*/

	
	function printBlogDesc($blogDesc){
		echo "<div class='alert alert-warning alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				$blogDesc
			</div>";
	}
	//include './footer.php';
?>