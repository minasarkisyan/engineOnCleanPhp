<?php

class Request
{
    private $data;

    public function __construct()
    {
        $this->data = $this->xss($_REQUEST);
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) return $this->data[$name];
    }

    public function xss($data)
    {
        if (is_array($data)) {
            $escaped = [];
            foreach ($data as $key => $value) {
                $escaped[$key] = $this->xss($value);
            }
            return $escaped;
        }
        return trim(htmlspecialchars($data));
    }
}