<?php

class Course extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("auth_user");
		$this->add("courses", null, true);
	}
	
	public function getTmplFile() {
		return "course";
	}
	
}

?>