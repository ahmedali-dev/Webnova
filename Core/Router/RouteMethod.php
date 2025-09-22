<?php

namespace Core\Router;


class RouteMethod{

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




    public function getCurrentUrl(): string{
        $uri = $_SERVER['REQUEST_URI'];
        $queryPos = strpos($uri,'?');
        
        return $queryPos === false ? $uri : substr($uri,0, $uri);
    }

    public function getCurrentMethod(): string{
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }
}

