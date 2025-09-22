<?php


namespace Core\Router;


class Request
{
    
    public readonly array $params;
    public readonly string $method;
    public readonly string $uri;
    public readonly array $headers;
    public readonly array $cookies;

    public function __construct(array $params = []){
        $this->params = $params;
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->headers = getallheaders();
        $this->cookies = $_COOKIE;
    }


    public function setCookie($name, string|array $value, $day)
    {
        if (isset($_COOKIE[$name])) {
            return $this;
        }

        $value = is_array($value) ? json_encode($value) : $value;

        setcookie($name, $value, time() + (86400 * $day), '/');

        return $this;
    }


    public function deleteCookie($name){
        if (isset($_COOKIE[$name])) {
            setcookie($name,'', time() - 3600, '/');
            unset($_COOKIE[$name]);
        }
        return $this;
    }

}