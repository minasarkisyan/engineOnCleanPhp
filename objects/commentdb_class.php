<?php

class CommentDB extends ObjectDB {

    protected static $table = "comments";

    public function __construct() {
        parent::__construct(self::$table);
        $this->add("article_id", "ValidateID");
        $this->add("user_id", "ValidateID");
        $this->add("parent_id", "ValidateID");
        $this->add("text", "ValidateSmallText");
        $this->add("date", "ValidateDate", self::TYPE_TIMESTAMP, $this->getDate());
    }

    protected function postInit() {
        $this->link = URL::get("article", "", array("id" => $this->article_id), false, Config::ADDRESS);
        $this->link = URL::addID($this->link, "comment_".$this->id);
        return true;
    }

    public static function getAllOnArticleID($article_id) {
        $select = new Select(self::$db);
        $select->from(self::$table, "*")
            ->where("`article_id` = ".self::$db->getSQ(), array($article_id))
            ->order("date");
        $comments = ObjectDB::buildMultiple(__CLASS__, self::$db->select($select));
        $comments = ObjectDB::addSubObject($comments, "UserDB", "user", "user_id");
        return $comments;
    }

    public static function getCountOnArticleID($article_id) {
        $select = new Select(self::$db);
        $select->from(self::$table, array("COUNT(id)"))
            ->where("`article_id` = ".self::$db->getSQ(), array($article_id));
        return self::$db->selectCell($select);
    }

    public function accessEdit($auth_user, $field) {
        if ($field == "text") {
            return $this->user_id == $auth_user->id;
        }
        return false;
    }

    public function accessDelete($auth_user) {
        return $this->user_id == $auth_user->id;
    }

    private static function getAllOnParentID($parent_id) {
        return self::getAllOnField(self::$table, __CLASS__, "parent_id", $parent_id);
    }

    protected function preDelete() {
        $comments = CommentDB::getAllOnParentID($this->id);
        foreach ($comments as $comment) {
            try {
                $comment->delete();
            } catch (Exception $e) {
                return false;
            }
        }
        return true;
    }

}
?>