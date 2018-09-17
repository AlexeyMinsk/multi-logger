<?php
namespace Logger;

include __DIR__ . '/WriterLog.php';

class XMLWriterLog extends WriterLog{
	
	private $path = null;
	private $xml = null;
	private $log = null;
	private $position = 11;
	
	function __construct($logPath){
		
		$this->path = $logPath;
	}
	
	function writeLog($mess = ""){
	
		if( !file_exists($this->path) || !filesize($this->path) || true){
			$this->xml = new \XMLWriter();
			$this->xml->openMemory();
			$this->xml->startDocument("1.0", "UTF-8");
			$this->xml->startElement("log-list");
			$this->xml->writeElement("data-create", date("d:m:Y G:i:s"));
				$this->xml->startElement("log");
					$this->xml->startAttribute('data-create');
							$this->xml->text(date("d:m:Y G:i:s"));
						$this->xml->endAttribute();
					$this->addBacktrace($this->xml);
					
					if( !empty($mess) ){
						$this->xml->writeElement("report", $mess);
					}
				$this->xml->endElement();
			$this->xml->endElement();
			$this->log = $this->xml->outputMemory();
		}
		else{
			$this->addNote($mess);
		}
	}
	
	function addBacktrace(&$xml){
		
		$trace = debug_backtrace();
		
		if( is_array($trace) && count($trace) ){
			
			$xml->startElement("backtrace");
			$counter = $index = count($trace);
			
			
			while($counter--){
				$xml->startElement("item");
					$xml->startAttribute('step');
						$xml->text($index - $counter);
					$xml->endAttribute();
					$xml->writeElement("file", $trace[$counter]['file']);
					$xml->writeElement("line", $trace[$counter]['line']);
					$xml->writeElement("function", $trace[$counter]['function']);
				$xml->endElement();
			}
			$xml->endElement();
		}
	}
	
	function addNote($mess){
		
		$fp = fopen( $this->path, 'r+');
		fseek($fp, -($this->position), SEEK_END);
		$elem = new \XMLWriter();
		$elem->openMemory();
		$elem->startElement("log");
			$elem->startAttribute('data-create');
					$elem->text(date("d:m:Y G:i:s"));
				$elem->endAttribute();
			$this->addBacktrace($elem);
			
			if( !empty($mess) ){
				$elem->writeElement("report", $mess);
			}
		$elem->endElement();
		$log = $elem->outputMemory();
		fwrite($fp, $log . '</log-list>');
		
		fclose($fp);
	}
	
	function getLog(){
		return $this->log;
	}
	
	public function writeToFile(){
		
		if( !empty($this->log) ){
			$writeRes = file_put_contents($this->path, $this->log);
			
			if($writeRes === false){
				return false;
			}
			return true;
		}
		return false;
	}
}

