<?php

class TopMenu extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("uri");
		$this->add("items", null, true);
	}
	
	public function getTmplFile() {
		return "topmenu";
	}
	
}

?>