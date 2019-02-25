<?php

class UserPanel extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("user");
		$this->add("uri");
		$this->add("items", null, true);
	}
	
	public function addItem($title, $link) {
		$cl = new stdClass();
		$cl->title = $title;
		$cl->link = $link;
		$this->items = $cl;
	}
	
	public function getTmplFile() {
		return "user_panel";
	}
	
}

?>