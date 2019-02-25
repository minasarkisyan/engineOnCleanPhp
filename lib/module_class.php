<?php

abstract class Module extends AbstractModule
{
    public function __construct()
    {
        parent::__construct(new View(Config::DIR_TMPL));
    }
}