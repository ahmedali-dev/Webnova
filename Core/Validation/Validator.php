<?php

namespace Core\Validation;

class Validator
{

    private array $data = [];
    private array $errors = [];
    public string $method = 'get';


    /**
     * Supported validation rules
     */
    private const AVAILABLE_RULES = [
        'require',
        'max',
        'min',
        'isString',
        'isNumber',
        'email',
        'extension',
        'boolean'
    ];


    public function __construct(array $validation = [])
    {

        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->getDataFromRequest();

        $this->validation($validation);

    }

    public function validation(array $validation)
    {
        if (!empty($validation)) {

            foreach ($validation as $field => $rules) {

                foreach ($rules as $rule) {

                    $args = $field;

                    // Parse rule with parameters (e.g., max:10)
                    if (strpos($rule, ':') !== false) {
                        [$rule, $param] = explode(':', $rule, 2);
                        $args = ['name' => $field, 'param' => $param];
                    }
                    if (
                        in_array(
                            $rule,
                                $this::AVAILABLE_RULES,
                        )
                    ) {
                        if (isset($this->errors[$field])) {
                            continue 2;
                        }

                       
                        call_user_func([$this, $rule], $args);
                    }
                }
            }
        }
    }

    private function require(string $name): void
    {
         
        if (isset($this->data[$name])) {
            return;
        }

        $this->errors[$name] = $name . ' is require';

    }

    private function isString(string $name)
    {
        $value = $this->data[$name];
        if (!is_string($value)) {
            $this->errors[$name] = "$name must be a string";
            return;
        }

        $this->data[$name] = htmlspecialchars($value, ENT_QUOTES,"");
    }


    private function isNumber(string $name)
    {
        $value = $this->value($name);
        if (is_numeric($value)) {
            $this->errors[$name] = "$name must be a number";
        }

        $this->data[$name] = filter_var(
            $value,
            FILTER_SANITIZE_NUMBER_INT,
            FILTER_FLAG_STRIP_LOW,
        );
    }

    private function max(array $arg)
    {
        $limit = (int) $arg['param'];

        if (mb_strlen($this->data[$arg['name']]) > $limit) {

            $this->errors[$arg['name']] = $arg['name'] . ' must be less than ' . $arg['param'];
        }
    }


    private function min(array $arg)
    {
        $limit = (int) $arg['param'];

        if (mb_strlen($this->data[$arg['name']]) < $limit) {

            $this->errors[$arg['name']] = $arg['name'] . ' must be greater than ' . $arg['param'];
        }
    }


    private function isBool(string $name){
        $value = $this->data[$name];
        if (!is_bool($value)) {
            $this->errors[$name] = "$name is not a valid boolean";
            return;
        }

        $this->data[$name] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }


    private function isEmail(string $name)
    {
        $value = $this->data[$name];
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$name] = "$name must be a valid email address";
        } else {
            $this->data[$name] = filter_var($value, FILTER_SANITIZE_EMAIL);
        }
    }

    private function extension(array $arg)
    {
        $value = $this->data[$arg["name"]] ?? '';
        $parts = explode('@', $value);
        if (count($parts) > 1) {
            $parts = end($parts);
            $validExtension = explode(',', $arg['param']);

            if (!in_array($parts, $validExtension)) {
                $this->errors[$arg['name']] = $arg['name'] . ' is not valid';
                return;
            }
            return;
        } else {
            $this->errors[$arg['name']] = "{$arg['name']} is not valid";
        }


    }



    /**
     * Return validation errors
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Return validated & sanitized data
     */
    public function validated(): array
    {
        return $this->data;
    }

    /**
     * Get request data
     */
    private function getDataFromRequest(): void
    {
        if ($this->method === 'post') {
            $this->data = $_POST;
        } elseif ($this->method === 'get') {
            $this->data = $_GET;
        } else {
            $this->data = json_decode(file_get_contents('php://input'), true) ?? [];
        }
    }
}