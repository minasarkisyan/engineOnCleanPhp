<?php

class PollDataDB extends ObjectDB {

    protected static $table = "poll_data";

    public function __construct() {
        parent::__construct(self::$table);
        $this->add("poll_id", "ValidateID");
        $this->add("title", "ValidateTitle");
    }

    public static function getAllOnPollID($poll_id) {
        return ObjectDB::getAllOnField(self::$table, __CLASS__, "poll_id", $poll_id, "id");
    }

    public static function getAllDataOnPollID($poll_id) {
        $poll_data = self::getAllOnPollID($poll_id);
        foreach ($poll_data as $pd) {
            $pd->voters = PollVoterDB::getCountOnPollDataID($pd->id);
        }
        uasort($poll_data, array(__CLASS__, "compare"));
        return $poll_data;
    }

    private static function compare($value_1, $value_2) {
        return $value_1->voters < $value_2->voters;
    }

}
