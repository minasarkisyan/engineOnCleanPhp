<?php

class PollDB extends ObjectDB {

    protected static $table = "polls";

    public function __construct() {
        parent::__construct(self::$table);
        $this->add("title", "ValidateTitle");
        $this->add("state", "ValidateBoolean", null, 0);
    }

    public function loadRandom() {
        $select = new Select(self::$db);
        $select->from(self::$table, "*")
            ->where("`state` = ".self::$db->getSQ(), array(1))
            ->rand()
            ->limit(1);
        $row = self::$db->selectRow($select);
        return $this->init($row);
    }

}
