<?php


namespace Core\Router;


class Request
{

    public array $params = [];
    public string $method = '';
    public string $uri = '';
    public array $headers = [];

    public array $cookies = [];

    public function __construct(array $params = []){
        $this->params = $params;
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->headers = getallheaders();
        $this->cookies = $_COOKIE;
    }


    public function setcookies($name, string|array $value, $day)
    {
        if (isset($_COOKIE[$name])) {
            return;
        }

        if (is_array($value)) {
            $value = json_encode($value);
        }

        setcookie($name, $value, time() + (86400 * $day), '/');

        return $this;
    }


    public function deletecookies($name){
        if (isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);
        }
        return $this;
    }

}