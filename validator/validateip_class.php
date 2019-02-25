<?php

class ValidateIP extends Validator {

    protected function validate() {
        $data = $this->data;
        if ($data == 0) return;
        if (!preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $data)) $this->setError(self::CODE_UNKNOWN);
    }

}