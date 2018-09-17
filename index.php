<?php
	use \Logger as Logger;
	
	require __DIR__ . "/XMLWriterLog.php";
	
	$log = new Logger\XMLWriterLog($_SERVER["DOCUMENT_ROOT"] . "/my_dir/logger/log.xml");
	//$log->writeLog("message 1");
	//$log->writeToFile();
	$log->addNote("message 2");
	
	//$fp = fopen( $_SERVER["DOCUMENT_ROOT"] . "/my_dir/logger/log.xml", 'r');
	//$position = 17;
	//fseek($fp, -$position, SEEK_END);
	//echo ftell( $fp );
	//$contents = fread($fp, $position);
	//fclose($fp);
	//var_dump($contents);


