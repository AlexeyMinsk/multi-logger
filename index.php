<?php
	use \Logger as Logger;
	
	require __DIR__ . "/logger.php";
	
	$log = new Logger\XMLWriterLog($_SERVER["DOCUMENT_ROOT"] . "/my_dir/logger/log.xml");
	$log->writeXLMLog();
	$log->writeXML();
