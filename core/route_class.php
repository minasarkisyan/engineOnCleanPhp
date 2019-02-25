<?php

class Route
{
    public static function start()
    {
        $ca_names = URL::getControllerAndAction();
        $controller_name = $ca_names[0]."Controller";
        $action_name = "action".$ca_names[1];
        try {
            if (class_exists($controller_name)) $controller = new $controller_name();
            if (method_exists($controller, $action_name)) $controller->$action_name();
            else throw new Exception();
        } catch (Exception $e) {
            if ($e->getMessage() != "ACCESS_DENIED") $controller->action404();
        }

    }
}