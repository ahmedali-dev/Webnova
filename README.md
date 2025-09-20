# Codenova Framework

A lightweight PHP framework for building MVC-style web applications with simple **routing**, **validation**, and **view handling**.

---

## ✨ Features

* 🚦 Simple and expressive **Routing**
* ✅ Built-in **Validation**
* 🖼️ **View rendering** with layout support
* 📦 Composer autoloading
* 🛠️ Lightweight and easy to extend

---

## 📥 Installation

Require the package via Composer:

```bash
composer require ahmedali-dev/codenova
```

Create a `public/index.php` file as your app entry point:

```php
<?php

require __DIR__ . "/../vendor/autoload.php";

// Initialize the view directory
Core\Config\ViewSetting::init();

use Core\Router\MatchRoute;
use Core\Router\Response;
use Core\Router\Request;

$route = new MatchRoute();
```

---

## 🚀 Getting Started

### 1. Define a Route

```php
$route->get("/", function (Request $request, Response $response) {
    return $response->view("User/Home", [
        'name' => 'Codenova Framework'
    ]);
});
```

### 2. Create a View

Create a file at:
`app/Views/User/Home.php`

```php
<h1>Welcome, <?= $name ?> 👋</h1>
```

### 3. Create a Layout

File:
`app/Views/Layout/Layout.php`

```php
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Codenova App</title>
</head>
<body>
  <?= $content ?>
</body>
</html>
```

### 4. Run a Local Server

Start PHP’s built-in server:

```bash
php -S localhost:8000 -t public
```

or use 

```bash
php start.php
```

Open your browser at 👉 [http://localhost:8000](http://localhost:8000)

You should see:

```
Welcome, Codenova Framework 👋
```

---

## 🚦 Advanced Routing

### Dynamic Parameters

```php
$route->get("/user/{id}", function (Request $request, Response $response) {
    echo "User ID: " . $request->params['id'];
});
```

### Multiple Handlers

```php
$route->get("/post/{id}", [
    function (Request $request, Response $response) {
        echo "Closure handler, method: " . $request->method;
    },
    'Post@show' // Controller@method
]);
```

### 404 Handling

```php
$route->notFound([
    function () {
        echo "Page not found, please try again.";
    },
    'ErrorController@notFound'
]);
```

---

## ✅ Validation Example

```php
$valid = $response->validator([
    "name"  => ['require', 'isString', 'max:20', 'min:8'],
    "email" => ['require', 'isEmail', 'extension:gmail.com,hotmail.com']
]);

if ($valid->errors()) {
    return $response->view("User/Home", ['errors' => $valid->errors()]);
}

// Access validated data
$validated = $valid->validated();
```

---

## 📂 Project Structure

```
app/
  Controllers/
  Database/
  Helper/
  Router/
  Views/
    Layout/
public/
  index.php
vendor/
```

---

## 📜 License

This project is licensed under the MIT License.

---

⚡ With just a few lines of code, you can have routes, validation, and views working out of the box!
