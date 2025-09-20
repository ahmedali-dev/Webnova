<?php

namespace Core\Router;


class Route{

    protected array $routes = [];

    

    public function addRoute(string $method, string $route, callable|string|array $controller){
        $method = strtolower($method);
        if(!isset($this->routes[$method])){
            $this->routes[$method] = [];
        }
        
        $this->routes[$method][] = [
            'route' => strtolower($route),
            'controller'=> $controller
        ];
    }
    public function get(string $path, callable|string|array $con): void
    {
        $this->addRoute('get', $path, $con);
    }

    /**
     * ! @param string $path => url path http://site.com/home
     * ! @param callable|string $con => class required
     */

    public function post(string $path, callable|string|array $con): void
    {
        $this->addRoute('post', $path, $con);
    }


    /**
     * ! @param string $path => url path http://site.com/home
     * ! @param callable|string $con => class required
     */

    public function delete(string $path, callable|string|array $con): void
    {
        $this->addRoute('delete', $path, $con);
    }


    /**
     * ! @param string $path => url path http://site.com/home
     * ! @param callable|string $con => class required
     */

    public function put(string $path, callable|string|array $con): void
    {
        $this->addRoute('put', $path, $con);
    }

    public function patch(string $path, callable|string|array $con): void{
        $this->addRoute('patch', $path, $con);
    }




    public function getUrl(): string{
        // check if the url have this '?'
        // if have '?' get the index in the url
        $url = strpos($_SERVER['REQUEST_URI'],'?');
        if(!$url){
            return $_SERVER["REQUEST_URI"];
        }
        return substr($_SERVER["REQUEST_URI"],0, $url);
    }

    public function getMethod(): string{
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }
}

