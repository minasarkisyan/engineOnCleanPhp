<?php

class Slider extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("course");
	}
	
	public function getTmplFile() {
		return "slider";
	}
	
}

?>