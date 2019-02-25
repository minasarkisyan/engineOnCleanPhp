<?php

class Category extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("category");
		$this->add("articles", null, true);
	}
	
	public function getTmplFile() {
		return "category";
	}
	
}

?>