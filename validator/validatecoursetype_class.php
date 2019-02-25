<?php

class ValidateCourseType extends Validator {

    const MAX_COURSETYPE = 3;

    protected function validate() {
        $data = $this->data;
        if (!is_int($data)) $this->setError(self::CODE_UNKNOWN);
        else {
            if (($data < 1) || ($data > self::MAX_COURSETYPE)) $this->setError(self::CODE_UNKNOWN);
        }
    }

}