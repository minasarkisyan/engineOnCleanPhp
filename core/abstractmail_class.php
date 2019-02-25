<?php

abstract class AbstractMail
{

    private $view;
    private $from;
    private $from_name = "";
    private $type= "text/html";
    private $encoding = "utf-8";

    public function __construct($view, $from) {
        $this->view = $view;
        $this->from = $from;
    }

    public function setFrom($from) {
        $this->from = $from;
    }

    public function setFromName($from_name) {
        $this->from_name = $from_name;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setEncoding($encoding) {
        $this->encoding = $encoding;
    }

    public function send($to, $data, $template) {
        $from = "=?utf-8?B?".base64_encode($this->from_name)."?="." <".$this->from.">";
        $headers = "From: ".$from."\r\nReply-To: ".$from."\r\nContent-type: ".$this->type."; charset=\"".$this->encoding."\"\r\n";
        $text = $this->view->render($template, $data, true);
        $lines = preg_split("/\\r\\n?|\\n/", $text);
        $subject = $lines[0];
        $subject = "=?utf-8?B?".base64_encode($subject)."?=";
        $body = "";
        for ($i = 1; $i < count($lines); $i++) {
            $body .= $lines[$i];
            if ($i != count($lines) - 1) $body .= "\n";
        }
        if ($this->type = "text/html") $body = nl2br($body);
        return mail($to, $subject, $body, $headers);
    }

}
