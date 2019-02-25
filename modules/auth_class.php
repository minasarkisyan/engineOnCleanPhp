<?php

class Auth extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("action");
		$this->add("message");
		$this->add("link_register");
		$this->add("link_reset");
		$this->add("link_remind");
	}
	
	public function getTmplFile() {
		return "auth";
	}
	
}

?>