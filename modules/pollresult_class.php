<?php

class PollResult extends ModuleHornav {
	
	public function __construct() {
		parent::__construct();
		$this->add("title");
		$this->add("message");
		$this->add("data", null, true);
	}
	
	public function preRender() {
		$this->add("count_voters");
		$count_voters = 0;
		foreach ($this->data as $d) $count_voters += $d->voters;
		$this->count_voters = $count_voters;
		foreach ($this->data as $d) {
			if ($count_voters != 0) $d->percent = round(($d->voters / $count_voters) * 100, 2);
			else $d->percent = 0;
		}
	}
	
	public function getTmplFile() {
		return "poll_result";
	}
	
}

?>