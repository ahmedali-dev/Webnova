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
        ob_start();
        require_once ViewSetting::$viewsDir . $file . '.php';
        $content = ob_get_clean();
        require_once ViewSetting::$viewsDir . 'layout/layout.php';
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