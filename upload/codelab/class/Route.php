<?php
namespace Codelab;

class Route
{
    public function __construct()
    {

        $route = $this -> parseRoute();

        echo "../app/controllers/". $url[0] . '.php';
        if (file_exists("../app/controllers/". $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once("../app/controllers/".$this->controller.".php");
        $this -> controller = new $this -> controller;
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this -> params = $url ? array_values($url) : [];
        call_user_func_array([$this -> controller, $this -> method], $this -> params);
    }

    public function parseRoute()
    {
        if (isset($_GET['route'])) {
            return $route = explode("/", filter_var(rtrim($_GET["route"], "/"), FILTER_SANITIZE_URL));
        }
    }
}

