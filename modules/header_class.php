<?php

class Header extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("title");
		$this->add("favicon");
		$this->add("meta", null, true);
		$this->add("css", null, true);
		$this->add("js", null, true);
	}
	
	public function meta($name, $content, $http_equiv) {
		$class = new stdClass();
		$class->name = $name;
		$class->content = $content;
		$class->http_equiv = $http_equiv;
		$this->meta = $class;
	}
	
	public function getTmplFile() {
		return "header";
	}
	
}

?>