<?php

namespace Core\Router;
use Core\Config\ViewSetting;
use Core\Validation\Validator;
class Response{
    private int $status = 200;
    public function status(int $code): Response{
        $this->status = $code;
        return $this;
    }

    public function view($file, $params = [])
    {
        $path = ViewSetting::$viewsDir . $file . '.php';
        if(!file_exists($path)){
            echo 'file path not found: '. $path;
            return;
        }
        ob_start();
        require_once $path;
        $content = ob_get_clean();
        $layoutPath = ViewSetting::$viewsDir . 'Layout/Layout.php';
        if (!file_exists($layoutPath)) {
            echo 'layout file not found: '. $layoutPath;
            return;
        }
        require_once $layoutPath;
        // ob_end_flush();
    }

    public function json($data = []){
        http_response_code($this->status);
        header('content-type: application/json');
        echo json_encode($data);
        return $this;
    }

    public function redirect(string $url):Response{
        header("Location: $url");
        return $this;
    }
    
    public function validator(array $validation) {
        return new Validator($validation);
    }
}