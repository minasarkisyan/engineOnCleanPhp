<?php

class SearchResult extends ModuleHornav {
	
	public function __construct() {
		parent::__construct();
		$this->add("query");
		$this->add("field");
		$this->add("error_len", false);
		$this->add("data", null, true);
	}
	
	protected function preRender() {
		$query = $this->query;
		$query = mb_strtolower($query);
		$query = preg_replace("/ {2,}/", " ", $query);
		foreach ($this->data as $d) $d->description = $this->getDescription($d->{$this->field}, $query);
	}
	
	private function getDescription($text, $query) {
		$len = Config::LEN_SEARCH_RES;
		if (strlen($text) > $len) {
			$i = 0;
			$k = 0;
			$array_words = explode(" ", $query);
			$pos = array();
			foreach ($array_words as $key => $value) {
				while (strpos($text, $value, $i) !== false) {
					$pos[$k] = strpos($text, $value, $i);
					$i += $pos[$k] + 1;
					if ($i < strlen($text)) $i = strlen($text);
					$k++;
				}
				$i = 0;
			}
			if (count($pos) != 0) {
				if (count($pos) > 1) {
					$k = 0;
					$max = 1;
					$max_freq = array();
					for ($i = 0; $i < count($pos); $i++) {
						$k = 1;
						$sum = 0;
						$temp_freq[$k - 1] = $pos[$i];
						for ($j = $i; $j < count($pos) - 1; $j++) {
							$sum += $pos[$j + 1] - $pos[$j];
							if ($sum <= $len) $k++;
							else break;
							$temp_freq[$k] = $pos[$j + 1];
						}
						if ($k > $max) {
							$max = $k;
							$max_freq = $temp_freq;
						}
					}
					if (count($max_freq) == 0) {
						$max = 0;
						$max_freq[] = $pos[0];
					}
				}
				else {
					$max = 0;
					$max_freq = $pos;
				}
				$free_space = $len - ($max_freq[$max] - $max_freq[0]);
				$start = $max_freq[0] - $free_space / 2;
				$end = $max_freq[$max] + $free_space / 2;
				if ($start < 0) {
					$end -= $start;
					$start = 0;
				}
				if ($end > strlen($text)) {
					$start -= ($end - strlen($text));
					$end = strlen($text);
				}
			}
			else {
				$start = 0;
				$end = $len;
			}
			while (!preg_match("/[[:space:]]/", substr($text, $start - 1, 1)) && ($start - 1) > 0)
				$start--;
			while (!preg_match("/[[:space:]]/", substr($text, $end, 1)) && $end < strlen($text))
				$end++;
		}
		else {
			$start = 0;
			$end = strlen($text);
		}
		if ($start == 1) $start = 0;
		if ($start < 1) $st_d = "";
		else $st_d = "... ";
		if ($end == strlen($text)) $end_d = "";
		else $end_d = " ...";
		$description = substr($text, $start, $end - $start);
		$description = $st_d.$description.$end_d;
		return $this->selectSearchWords($description, $query);
	}
	
	private function selectSearchWords($description, $query) {
		$array_words = explode(" ", $query);
		foreach ($array_words as $value) {
			$description = preg_replace("/".$value."/i", "<span>$value</span>", $description);
		}
		return $description;
	}
	
	public function getTmplFile() {
		return "search_result";
	}
	
}

?>