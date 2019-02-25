<?php

class File
{

    public static function uploadIMG($file, $max_size, $dir, $root = false, $source_name = false)
    {
        $blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");
        foreach ($blacklist as $item)
            if (preg_match("/$item\$/i", $file["name"])) throw new Exception("ERROR_AVATAR_TYPE");
        $type = $file["type"];
        $size = $file["size"];
        if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/gif") && ($type != "image/png")) throw new Exception("ERROR_AVATAR_TYPE");
        if ($size > $max_size) throw new Exception("ERROR_AVATAR_SIZE");
        if ($source_name) $avatar_name = $file["name"];
        else $avatar_name = self::getName().".".substr($type, strlen("image/"));
        $upload_file = $dir.$avatar_name;
        if (!$root) $upload_file = $_SERVER["DOCUMENT_ROOT"].$upload_file;
        if (!move_uploaded_file($file["tmp_name"], $upload_file)) throw new Exception("UNKNOWN_ERROR");
        return $avatar_name;
    }

    public static function getName() {
        return uniqid();
    }

    public static function delete($file, $root = false) {
        if (!$root) $file = $_SERVER["DOCUMENT_ROOT"].$file;
        if (file_exists($file)) unlink($file);
    }

    public static function isExists($file, $root = false) {
        if (!$root) $file = $_SERVER["DOCUMENT_ROOT"].$file;
        return file_exists($file);
    }
}
