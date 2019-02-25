<?php

class Captcha {

    const WIDTH = 100;
    const HEIGHT = 60;
    const FONT_SIZE = 16;
    const LET_AMOUNT = 4;
    const BG_LET_AMOUNT = 30;
    const FONT = "fonts/verdana.ttf";

    private static $letters = array("a", "b", "c", "d", "e", "f", "g");
    private static $colors = array(90, 110, 130, 150, 170, 190, 210);

    public static function generate() {
        if (!session_id()) session_start();
        $src = imagecreatetruecolor(self::WIDTH, self::HEIGHT);
        $bg = imagecolorallocate($src, 255, 255, 255);
        imagefill($src, 0, 0, $bg);

        for ($i = 0; $i < self::BG_LET_AMOUNT; $i++) {
            $color = imagecolorallocatealpha($src, rand(0, 255), rand(0, 255), rand(0, 255), 100);
            $letter = self::$letters[rand(0, count(self::$letters) - 1)];
            $size = rand(self::FONT_SIZE - 2, self::FONT_SIZE + 2);
            imagettftext($src, $size, rand(0, 45), rand(self::WIDTH * 0.1, self::WIDTH * 0.9), rand(self::HEIGHT * 0.1, self::HEIGHT * 0.9), $color, self::FONT, $letter);
        }
        $code = "";
        for ($i = 0; $i < self::LET_AMOUNT; $i++) {
            $color = imagecolorallocatealpha($src, self::$colors[rand(0, count(self::$colors) - 1)],
                self::$colors[rand(0, count(self::$colors) - 1)],
                self::$colors[rand(0, count(self::$colors) - 1)], rand(20, 40));
            $letter = self::$letters[rand(0, count(self::$letters) - 1)];
            $size = rand(self::FONT_SIZE * 2 - 2, self::FONT_SIZE * 2 + 2);
            $x = ($i + 1) * self::FONT_SIZE + rand(1, 5);
            $y = ((self::HEIGHT * 2) / 3) + rand(0, 5);
            imagettftext($src, $size, rand(0, 15), $x, $y, $color, self::FONT, $letter);
            $code .= $letter;
        }
        $_SESSION["rand_code"] = $code;
        header("Content-type: image/gif");
        imagegif($src);
    }

    public static function check($code) {
        if (!session_id()) session_start();
        return ($code === $_SESSION["rand_code"]);
    }
}
