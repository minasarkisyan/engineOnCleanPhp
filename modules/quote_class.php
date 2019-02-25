<?php

class Quote extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("quote");
	}
	
	public function getTmplFile() {
		return "quote";
	}
	
}

?>