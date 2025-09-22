<?php

namespace Core\Router;

use Core\Config\ViewSetting;


// use Core\Router\Route;

class MatchRoute extends RouteMethod
{

    protected array $params = [];
    protected array $matchedRoute = [];

    /**
     * @var string|array|callable
     */
    protected $notFoundHandler = null;

    /**
     * next callback
     * @var bool
     */
    private bool $shouldContinue = false;
    private bool $isError = false;

    public function __destruct()
    {
        $this->findMatchingRoute();
        // echo '<hr> matched route is => ' . $this->matchedRoute['route'] . '<hr>';
        $this->routeHandler();
    }

    public function findMatchingRoute(): void
    {

        $url = $this->getCurrentUrl();
        $urlParts = $this->parseUrlParts($url);
        $method = $this->getCurrentMethod();


        if (!isset($this->routes[$method])) {
            return;
        }

        $routes = $this->routes[$method];

        foreach ($routes as $route) {

          
            if ($this->isExactMatch($url, $route['route'])) {
                $this->matchedRoute = $route;
                return;
            }


            if($this->isParameterizedMatch($route['route'], $urlParts)) {
                $this->matchedRoute = $route;
                return;
            }

            // return;
        }
    }

    /**
     * Check for exact route match
     */
    private function isExactMatch(string $url, string $routePattern): bool
    {
        return $url === $routePattern;
    }


    /**
     * Check for parameterized route match
     */

    private function isParameterizedMatch(string $routePattern, array $urlParts)
    {
        $routeParts = $this->parseUrlParts($routePattern);

        if (count($routeParts) !== count($urlParts)) {
            return false;
        }




        if ($this->getParams($routeParts, $urlParts) === false) {
            return false;
        }

        return true;
    }

    private function parseUrlParts(string $url): array
    {
        return explode('/', trim($url, '/'));
    }

    private function getParams(array $routeParts, array $urlParts): bool
    {
        $params = [];
        foreach ($routeParts as $index => $routePart) {

            if ($this->isParameter($routePart)) {
                $paramName = $this->extractParameterName($routePart);
                $params[$paramName] = $urlParts[$index];
            } else if ($routePart !== $urlParts[$index]) {
                return false;
            }
        }

        $this->params = $params;
        return true;
    }

    /**
     * Check if route part is a parameter
     */
    private function isParameter(string $part): bool
    {
        return str_starts_with($part, '{') && str_ends_with($part, '}');
    }

    private function extractParameterName(string $part): string
    {
        return substr($part, 1, -1);
    }

    private function routeHandler()
    {

        if ($this->matchedRoute === []) {

            if (isset($this->notFoundHandler)) {
                $this->matchedRoute = ['route' => '/notFound', 'controller' => $this->notFoundHandler];
                // return;
            } else {
                echo 'not found page';
                return;
            }

        }



        $argument = [
            new Request($this->params),
            new Response(),
            $this->showContinue()
        ];
        if (is_callable($this->matchedRoute['controller'])) {
            return call_user_func_array($this->matchedRoute['controller'], $argument);
        }


        $controllers = $this->matchedRoute['controller'] ? $this->matchedRoute['controller'] : [$this->matchedRoute['controller']];

        foreach ($controllers as $controllerNumber => $controller) {

            if ($controllerNumber > 0) {

                if ($this->shouldContinue === false) {

                    return;
                }
            }

            $this->shouldContinue = false;
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

    public function notFound(string|array|callable $con)
    {
        $this->notFoundHandler = $con;
    }

    private function showContinue()
    {
        return function ($error = null) {
            if (isset($error)) {
                $this->isError = true;
                return;
            }
            $this->shouldContinue = true;
            return $this->shouldContinue;
        };
    }
}

