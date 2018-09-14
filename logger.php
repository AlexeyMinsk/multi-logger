<?php
namespace Logger;

class XMLWriterLog{
	
	private $path = null;
	private $xml = null;
	private $doc = null;
	
	function __construct($logPath){
		
		$this->path = $logPath;
		//$this->writeXLMLog();
		//$this->writeXML();
	}
	
	function writeXLMLog(){
	
		$this->xml = new \XMLWriter();
		$this->xml->openMemory();
		$this->xml->startDocument("1.0", "UTF-8");
		$this->xml->startElement("log-list");
		$this->xml->writeElement("data-create", date("d:m:Y G:i:s"));
			$this->xml->startElement("log");
				$this->xml->startAttribute('data-create');
						$this->xml->text(date("d:m:Y G:i:s"));
					$this->xml->endAttribute();
				$this->addBacktrace();
			$this->xml->endElement();
		$this->xml->endElement();
		$this->doc = $this->xml->outputMemory();
	}
	
	function addBacktrace(){
		
		$trace = debug_backtrace();
		
		if( is_array($trace) && count($trace) ){
			
			$this->xml->startElement("backtrace");
			$counter = count($trace);
			
			while($counter--){
				$this->xml->startElement("step");
					$this->xml->writeElement("file", $trace[$counter]['file']);
					$this->xml->writeElement("line", $trace[$counter]['line']);
					$this->xml->writeElement("function", $trace[$counter]['function']);
				$this->xml->endElement();
			}
			$this->xml->endElement();
		}
	}
	
	function getXMLDocument(){
		return $this->doc;
	}
	
	public function writeXML(){
		
		if( !empty($this->doc) ){
			$writeRes = file_put_contents($this->path, $this->doc);
			
			if($writeRes === false){
				return false;
			}
			return true;
		}
		return false;
	}
}

