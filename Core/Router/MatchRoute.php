<?php

namespace Core\Router;

use Core\Config\ViewSetting;
use ErrorException;
use Exception;

// use Core\Router\Route;

class MatchRoute extends Route
{

    protected array $params = [];
    protected array $route = [];

    /**
     * @var string|array|callable
     */
    protected $notFoundPage = null;
    public function __destruct()
    {
        $this->matchs();
        $this->routeHandler();
    }

    public function matchs(): void
    {
        $url = $this->getUrl();
        $urlParts = explode('/', substr($url, 1));
        $method = $this->getMethod();


        $routes = $this->routes[$method];


        // echo $url . '====>';

        foreach ($routes as $route) {
            // echo $route['route'] . '----' . $url . '<br>';
            echo $url . '====>' .$route['route'] . '<br>';
            if ($url == $route['route']) {
                echo 'route is match' . $route['route'] . '<br>';
                $this->route = $route;
                return;
            }

            $routeParts = explode('/', substr($route['route'], 1));

            if (count($routeParts) !== count($urlParts)) {
                continue;
            }




            if ($this->getParams($routeParts, $urlParts) == false) {
                continue;
            }


            $this->route = $route;

            echo '<pre>';
            // print_r($route);
            // print_r($this->params);
            // print_r($routeParts);
            print_r($this->route);
            echo '</pre>';
            return;
        }
    }

    private function getParams(array $routeParts, array $urlParts): bool
    {
        foreach ($routeParts as $index => $routePart) {

            if (strpos($routePart, '{') === 0) {
                $this->params[substr($routePart, 1, -1)] =
                    $urlParts[$index];
            } else if ($routePart !== $urlParts[$index]) {
                return false;
            }
        }

        return true;
    }

    private function routeHandler()
    {

        if ($this->route === []) {

            if (isset($this->notFoundPage)) {
                $this->route = ['route' => '/notFound', 'controller' => $this->notFoundPage];
                // return;
            } else {
                echo 'not found page';
                return;
            }
        }
        $argument = [
            new Request($this->params),
            new Response()
        ];
        if (is_callable($this->route['controller'])) {
            return call_user_func_array($this->route['controller'], $argument);
        }

        $controllers = $this->route['controller'] ? $this->route['controller'] : [$this->route['controller']];

        foreach ($controllers as $controller) {
            if (is_callable($controller)) {
                call_user_func_array($controller, $argument);
                continue;
            }

            [$controllerClass, $controllerMethod] = explode('@', $controller);
            $classPath = ViewSetting::$controllersDir . $controllerClass . '.php';

            if (!file_exists($classPath)) {
                throw new Exception("Controller file not found: {$classPath}");
            }

            
            require_once $classPath;

            if (!class_exists($controllerClass)) {
                throw new Exception("Controller class not found: {$controllerClass}");
            }

            $instance = new $controllerClass();

            if (!method_exists($instance, $controllerMethod)) {
                throw new Exception("Method {$controllerMethod} not found in {$controllerClass}");
            }

            call_user_func_array([$instance, $controllerMethod], $argument);
        }
    }

    public function notFound(string|array|callable $con){
        $this->notFoundPage = $con;
    }
}

//MatchRoute

// $r = new index();

// $r->get('/', function () {
//     echo 'hello';
// });


