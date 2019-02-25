<?php

class MainMenu extends Module {
	
	public function __construct() {
		parent::__construct();
		$this->add("uri");
		$this->add("items", null, true);
	}
	
	public function preRender() {
		$this->add("childrens", null, true);
		$this->add("active", null, true);
		$childrens = array();
		foreach ($this->items as $item) {
			if ($item->parent_id) {
				$childrens[$item->id] = $item->parent_id;
			}
		}
		$this->childrens = $childrens;
		$active = array();
		foreach ($this->items as $item) {
			if ($item->link == $this->uri) {
				$active[] = $item->id;
				if ($item->parent_id) {
					$parent_id = $item->parent_id;
					$active[] = $parent_id;
					while ($parent_id) {
						$parent_id = $this->items[$parent_id]->parent_id;
						if ($parent_id) $active[] = $parent_id;
					}
				}
			}
		}
		$this->active = $active;
	}
	
	public function getTmplFile() {
		return "mainmenu";
	}
	
}

?>