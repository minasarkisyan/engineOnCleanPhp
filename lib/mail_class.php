<?php

class Mail extends AbstractMail
{
    public function __construct()
    {
        parent::__construct(new View(Config::DIR_EMAILS), Config::ADM_EMAIL);
        $this->setFrom(Config::ADM_NAME);
    }
}