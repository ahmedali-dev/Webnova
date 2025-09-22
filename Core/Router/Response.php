<?php

namespace Core\Router;
use Core\Config\ViewSetting;
use Core\Validation\Validator;
class Response
{
    private int $status = 200;

    private array $headers = [];
    public function status(int $code): Response
    {
        $this->status = $code;
        return $this;
    }

    public function view($file, $params = [])
    {
        $path = ViewSetting::$viewsDir . $file . '.php';


        if (!file_exists($path)) {
            return;
        }

        extract($params);
        ob_start();
        require_once $path;
        $content = ob_get_clean();
        $layoutPath = ViewSetting::$viewsDir . 'Layout/Layout.php';
        if (!file_exists($layoutPath)) {
            echo $content;
            return;
        }
        require_once $layoutPath;
        
    }



    public function json($data = [])
    {
        http_response_code($this->status);
        header('content-type: application/json');
        echo json_encode($data, JSON_THROW_ON_ERROR);
        return $this;
    }

    public function redirect(string $url): Response
    {
        header("Location: $url");
        return $this;
    }

    public function validator(array $validation)
    {
        return new Validator($validation);
    }
}