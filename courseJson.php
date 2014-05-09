<?php
	include './getMarks.php';
	$sem = $_GET['sem'];
	$subCodes = retrieveSubjectHeaders($sem);
	
	$blogs = new DOMDocument;
	$blogs->load('./resorces/sem8Blog.json');
	print_r ($blogs);
?>