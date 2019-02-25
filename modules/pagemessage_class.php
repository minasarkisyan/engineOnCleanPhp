<?php

class PageMessage extends ModuleHornav {
	
	public function __construct() {
		parent::__construct();
		$this->add("header");
		$this->add("text");
	}
	
	public function getTmplFile() {
		return "page_message";
	}
	
}

?>