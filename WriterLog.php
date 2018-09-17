<?php
	namespace Logger;
	
	abstract class WriterLog{
		
		abstract function writeLog();
		abstract function writeToFile();
		abstract function addNote($mess);
		abstract function addBacktrace();
		abstract function getLog();
	}