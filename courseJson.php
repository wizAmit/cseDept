<?php
	/*include './getMarks.php';
	$sem = $_GET['sem'];
	$subCodes = retrieveSubjectHeaders($sem);*/
	
	$str_data = file_get_contents("./resources/sem8blog.json");
	//$data = json_decode($str_data,true);
 
	$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($str_data, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

foreach ($jsonIterator as $key => $val) {
    if(is_array($val)) {
        echo "$key:\n";
    } else {
        echo "$key => $val\n";
    }
}
 
	/*// Modify the value, and write the structure to a file "data_out.json"
	//
	$data["boss"]["Hobbies"][0] = "Swimming";

	$fh = fopen("data_out.json", 'w')
		  or die("Error opening output file");
	fwrite($fh, json_encode($data,JSON_UNESCAPED_UNICODE));
	fclose($fh);*/
?>