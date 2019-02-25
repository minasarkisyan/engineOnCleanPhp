<?php

class Pagination extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("url");
		$this->add("url_page");
		$this->add("count_elements");
		$this->add("count_on_page");
		$this->add("count_show_pages");
		$this->add("active");
	}
	
	public function getTmplFile() {
		return "pagination";
	}
	
}

?>