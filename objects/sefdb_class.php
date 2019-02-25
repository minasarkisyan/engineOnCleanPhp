<?php

class SefDB extends ObjectDB {

    protected static $table = "sef";

    public function __construct() {
        parent::__construct(self::$table);
        $this->add("link", "ValidateURI");
        $this->add("alias", "ValidateTitle");
    }

    public function loadOnLink($link) {
        return $this->loadOnField("link", $link);
    }

    public function loadOnAlias($alias) {
        return $this->loadOnField("alias", $alias);
    }

    public static function getAliasOnLink($link) {
        $select = new Select(self::$db);
        $select->from(self::$table, array("alias"))
            ->where("`link` = ".self::$db->getSQ(), array($link));
        return self::$db->selectCell($select);
    }

    public static function getLinkOnAlias($alias) {
        $select = new Select(self::$db);
        $select->from(self::$table, array("link"))
            ->where("`alias` = ".self::$db->getSQ(), array($alias));
        return self::$db->selectCell($select);
    }

}