<?php

class ValidateMD extends Validator {

    const MAX_LEN = 255;
    const CODE_EMPTY = "ERROR_MD_EMPTY";
    const CODE_MAX_LEN = "ERROR_MD_MAX_LEN";

    protected function validate() {
        $data = $this->data;
        if (mb_strlen($data) == 0) $this->setError(self::CODE_EMPTY);
        if (mb_strlen($data) > self::MAX_LEN) $this->setError(self::CODE_MAX_LEN);
    }

}
