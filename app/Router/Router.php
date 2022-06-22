<?php
namespace Router;

include_once __DIR__.'/../Controllers/Controller.php';
use Controller\Controller;

class Router
{

    protected array $get = array();
    protected array $post = array();
    protected Controller $con;


    //__construct
    function __construct()
    {
        $this->con = new Controller();
    }

    // retrun router class
    public static function getRouter()
    {
        return new Router();
    }


    function Get($path, $fn = '', $callbak = '')
    {
        $this->get[$path] = $fn;
    }

    function Post($path, $fn = '', $callbak = '')
    {
        $this->post[$path] = $fn;
    }


    /**
        *@retrun $fn
     */
    function Run()
    {
//        echo "<pre>";
//        var_dump($this->get);
//        echo "</pre>";

        $pathInfo = $_SERVER['PATH_INFO'] ?? '/';
        $RM = $_SERVER['REQUEST_METHOD'];

        if ($RM === 'GET') {
            $fn = $this->get[$pathInfo] ?? NULL;
        }else if ($RM === 'POST') {
            $fn = $this->post[$pathInfo] ?? NULL;
        }else if ($RM === "DELETE") {
            echo "delete";
        }

        if ($fn) {
            call_user_func_array(array($this->con, $fn), array($this));
        }else {
            return $fn;
        }
    }

    /**
     * @return array
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }


}

$Router = new Router();
$Router->Get("/home", "home");
$Router->Post("/home", "postHome");
$Router->Post("/", "postHome");
$Router->Get("/", "home");



$Router->Get("/login", 'login');



$Router->Run();