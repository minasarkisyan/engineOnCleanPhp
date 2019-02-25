<?php

class ValidateDate extends Validator
{
    protected function validate()
    {
        $data = $this->data;
        if (!is_null($data) && strtotime($data) === false) $this->setErrors(self::CODE_UNKNOWN);
    }
}