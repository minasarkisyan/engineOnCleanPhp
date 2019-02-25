<?php

class ValidateName extends Validator {

    const MAX_LEN = 100;
    const CODE_EMPTY = "ERROR_NAME_EMPTY";
    const CODE_INVALID = "ERROR_NAME_INVALID";
    const CODE_MAX_LEN = "ERROR_NAME_MAX_LEN";

    protected function validate() {
        $data = $this->data;
        if (mb_strlen($data) == 0) $this->setError(self::CODE_EMPTY);
        else {
            if (mb_strlen($data) > self::MAX_LEN) $this->setError(self::CODE_MAX_LEN);
            elseif ($this->isContainQuotes($data)) $this->setError(self::CODE_INVALID);
        }
    }

}
