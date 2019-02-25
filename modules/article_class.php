<?php

class Article extends ModuleHornav {
	
	public function __construct() {
		parent::__construct();
		$this->add("auth_user");
		$this->add("article");
		$this->add("prev_article");
		$this->add("next_article");
		$this->add("link_register");
		$this->add("comments");
	}
	
	protected function preRender() {
		$this->add("childrens");
		$childrens = array();
		foreach ($this->comments as $comment) {
			$childrens[$comment->id] = $comment->parent_id;
		}
		$this->childrens = $childrens;
	}
	
	public function getTmplFile() {
		return "article";
	}
	
}

?>