<?php

namespace Core\Utils;
use Core\Config\ViewSetting;

class DotEnv
{
    
    // env file path
    private string $path = "";

    // env variables
    private array $variables = [];

    /**
     * load environment variable from .env file
     * @param string $path
     * @throws \Exception
     * @return $this;
     */
    public function load(string $path = ""): dotEnv
    {
        
        if (empty($path)) {
            $this->path = ViewSetting::$envFile;
        }else {
            $this->path = getcwd() . "/" . $path;
        }

        


        // check path exist
        if (!file_exists($this->path)) {
            throw new \Exception("Environment file not found: " . $this->path);
        }

        // check file is readable
        if(!is_readable($this->path)) {
            throw new \Exception("Environment file is not readable: ". $this->path);   
        }

        // open .env file and get lines
        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $lineNumber => $line) {
            $this->parseLine($lineNumber+1, $line);
        }
        


        // apply variables to $_ENV
        foreach ($this->variables as $key => $value) {
            $_ENV[$key] = $value;
            putenv("$key=$value");   
        }

        return $this;
    }

    private function parseLine($lineNumber, $line) {
        $line = trim($line);

        // skip empty and comments line
        if (empty($line) || $line[0] === '#') {
            return;
        }

        // check for valid format
        if(strpos($line, '=') === false) {
            throw new \Exception("Invalid format on line {$lineNumber}");
        }

        list($key, $value) = explode("=", $line,2);

        $key = trim($key);
        $value = trim($value);

        // remove surrounding quotes
        $value = trim($value, '"\'');

        $this->variables[$key] = $value;


    }

    public static function loader($path='') {
        $dotEnv = new DotEnv();
        if(isset($path)) {
            $dotEnv->load($path);
        }else {
            $dotEnv->load();
        }
    }
}