<?php

namespace Core\Router;
use Core\Config\ViewSetting;
use Core\Router\Response;
use Core\Router\Request;
class oldRouter
{

    /**
     * @var array $routes
     */

    public static array $routes = [];


    /**
     * @var string $NotFoundClass
     */
    public static string $NotFoundClass = 'notFound';

    /**
     * @var string $NotFoundFun
     * */
    public static string $NotFoundFun = 'index';


    /**
     * ! @param string $path => url path http://site.com/home
     * ! @param callable|string $con => class required
     */

    public static function get(string $path, callable|string|array $con): void
    {
        self::AddRoute('get', $path, $con);
    }

    /**
     * ! @param string $path => url path http://site.com/home
     * ! @param callable|string $con => class required
     */

    public static function post(string $path, callable|string|array $con): void
    {
        self::AddRoute('post', $path, $con);
    }


    /**
     * ! @param string $path => url path http://site.com/home
     * ! @param callable|string $con => class required
     */

    public static function delete(string $path, callable|string|array $con): void
    {
        self::AddRoute('delete', $path, $con);
    }


    /**
     * ! @param string $path => url path http://site.com/home
     * ! @param callable|string $con => class required
     */

    public static function put(string $path, callable|string|array $con): void
    {
        self::AddRoute('put', $path, $con);
    }

    /**
     * @param string $method
     * @param string $path
     * @param string|callable $con => controller
     */

    private static function AddRoute(string $method, string $path, string|callable|array $con): void
    {
        self::$routes[] = array(
            'path' => strtolower($path),
            'method' => $method,
            'controller' => $con
        );
    }

    public static function Dispatch(): void
    {

        $url_parts = explode("/", substr(strtolower(self::getRequestPath()), 1));
        foreach (self::$routes as $route) {
            $params = [];

            $path_parts = explode('/', substr($route['path'], 1));

            if (count($path_parts) !== count($url_parts)) {
                continue;
            }

            if (self::GetMethod() !== $route['method']) {
                continue;
            }

            foreach ($path_parts as $idx => $val) {
                if (strpos($val, '{') === 0) {
                    $params[substr($val, 1, -1)] = $url_parts[$idx];
                } else if ($val !== $url_parts[$idx]) {
                    continue 2;
                }

            }

            if (is_callable($route['controller'])) {
                call_user_func_array($route['controller'], [
                    new Request($params), // request
                    new Response()                   // response
                ]);


            } elseif (is_array($route['controller'])) {
                for ($i = 0; $i < count($route['controller']); $i++) {
                    if (is_callable($route['controller'][$i])) {
                        call_user_func_array($route['controller'][$i], [...array_values($params)]);
                    } else {
                        $controller = explode('@', $route['controller'][$i]);
                        $controller_class = $controller[0];
                        $controller_fun = $controller[1];
                        $classPath =  ViewSetting::$controllersDir . $controller_class . ".php";

                        require_once $classPath;
                        call_user_func_array(array(new $controller_class, $controller_fun), array(...array_values($params)));
                    }
                }
            } else {
                $controller = explode('@', $route['controller']);
                $controller_class = $controller[0];
                $controller_fun = $controller[1];
                $classPath =  ViewSetting::$controllersDir . $controller_class . ".php";

                require_once $classPath;
                call_user_func_array(array(new $controller_class, $controller_fun), array(...array_values($params)));
            }
            return;
        }

        self::ErrorPage();

    }

    public static function ErrorPage()
    {
        $controller = new \App\Controllers\notFound();
        return call_user_func_array([$controller, self::$NotFoundFun], []);
    }


    /**
     * get url request and handler
     * @return string
     *
     */

    public static function getRequestPath(): string
    {
        $path = $_SERVER['REQUEST_URI'];
        $pos = strpos($path, '?');
        if (!$pos) {
            return $path;
        } else {
            return substr($path, 0, $pos);
        }
    }

    /**
     * Get request method
     * @return string
     */

    public static function GetMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }


    public static function print($r): void
    {
        echo "<pre>";
        var_dump($r);
        echo "</pre>";
    }


}