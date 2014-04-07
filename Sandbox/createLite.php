<?php
   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('attendance.db');
      }
   }
   $db = sqlite_open('attendance', 0666, $sqliteerror);
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   } 

   $ret = sqlite3::sqlite_query($db, 'CREATE TABLE `da_sem2` (DateTime DATETIME CURRENT_TIMESTAMP NOT NULL)');
   if(!$ret){
	echo $db->lastErorMsg();
   }  else  {
	echo 'Table created Successfully.\n';
   }

   for ($x=11500113073; $x<11500113124; $x++){
		$ret = sqlite3::sqlite_query($db, 'ALTER TABLE `da_sem2` ADD `".$x."` BOOLEAN NOT NULL DEFAULT TRUE');
		if(!$ret)
			echo $db->lastErrorMsg();
		else
			echo $x." is added.";
	} 
	echo 'FINISHED.';
  $db->close();
?>