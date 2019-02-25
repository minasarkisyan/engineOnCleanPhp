<?php

class PollVoterDB extends ObjectDB {

    protected static $table = "poll_voters";

    public function __construct() {
        parent::__construct(self::$table);
        $this->add("poll_data_id", "ValidateID");
        $this->add("ip", "ValidateIP", self::TYPE_IP, $this->getIP());
        $this->add("date", "ValidateDate", self::TYPE_TIMESTAMP, $this->getDate());
    }

    public static function getCountOnPollDataID($poll_data_id) {
        return ObjectDB::getCountOnField(self::$table, "poll_data_id", $poll_data_id);
    }

    public static function isAlreadyPoll($poll_data_ids) {
        $select = new Select(self::$db);
        $select->from(self::$table, array("id"))
            ->whereIn("poll_data_id", $poll_data_ids)
            ->where("`ip` = ".self::$db->getSQ(), array(ip2long($_SERVER["REMOTE_ADDR"])))
            ->limit(1);
        return (self::$db->selectCell($select))? true: false;
    }

}
