<?php

class CourseDB extends ObjectDB {

    protected static $table = "courses";

    public function __construct() {
        parent::__construct(self::$table);
        $this->add("type", "ValidateCourseType");
        $this->add("header", "ValidateTitle");
        $this->add("sub_header", "ValidateTitle");
        $this->add("img", "ValidateIMG");
        $this->add("link", "ValidateURL");
        $this->add("text", "ValidateText");
        $this->add("did", "ValidateID");
        $this->add("latest", "ValidateBoolean");
        $this->add("section_id", "ValidateIDs");
    }

    protected function postInit() {
        $this->img = Config::DIR_IMG.$this->img;
        return true;
    }

    public function loadOnSectionID($section_id, $type) {
        $select = new Select();
        $select->from(self::$table, "*")
            ->where("`type` = ".self::$db->getSQ(), array($type))
            ->where("`latest` = ".self::$db->getSQ(), array(1))
            ->rand();
        $data_1 = self::$db->select($select);
        $select = new Select();
        $select->from(self::$table, "*")
            ->where("`type` = ".self::$db->getSQ(), array($type));
        if ($section_id) $select->whereFIS("section_ids", $section_id);
        $select->rand();
        $data_2 = self::$db->select($select);
        $data = array_merge($data_1, $data_2);
        if (count($data) == 0) {
            $select = new Select();
            $select->from(self::$table, "*")
                ->where("`type` = ".self::$db->getSQ(), array($type))
                ->rand();
            $data = self::$db->select($select);
        }
        $data = ObjectDB::buildMultiple(__CLASS__, $data);
        uasort($data, array(__CLASS__, "compare"));
        $first = array_shift($data);
        $this->load($first->id);
    }

    private function compare($value_1, $value_2) {
        if ($value_1->latest != $value_2->latest) return $value_1->latest < $value_2->latest;
        if ($value_1->type == $value_2->type) return 0;
        return $value_1->type > $value_2->type;
    }

}
