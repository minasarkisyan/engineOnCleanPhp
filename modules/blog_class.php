<?php

class Blog extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("articles", null, true);
		$this->add("more_articles", null, true);
		$this->add("pagination");
	}
	
	public function preRender() {
		foreach ($this->articles as $article) {
			$article->count_comments_text = $this->numberOf($article->count_comments, array("комментарий", "комментария", "комментариев"));
		}
	}
	
	public function getTmplFile() {
		return "blog";
	}
	
}

?>