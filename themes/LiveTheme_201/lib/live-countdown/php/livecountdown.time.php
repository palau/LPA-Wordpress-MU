<?php
  // TODO needed?
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1 
	header("Expires: Fri, 1 Jan 2010 08:00:00 GMT"); // Date in the past 
	
	$day = $_GET['d'];
	$month = $_GET['m'];
	$year = $_GET['y'];
	$hour = $_GET['h'];
	$minute = $_GET['min'];
	
	$now = new DateTime(); 
	//echo $now->format(02 . " " . 5 . ", " . 2011 . " " . 9 . ":" . 22 . ":" . 0 . " O")."\n"; 
	echo $now->format($month . " " . $day . ", " . $year . " " . $hour . ":" . $minute . ":" . 0 . " O")."\n"; 
	
?>