<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "Config/Config.php";
require_once "System/Controller.php";
require_once "System/Conexion.php";
require_once "System/Mysql.php";
require_once "System/Middleware.php"; // << nueva línea
require_once "Helpers/Helpers.php";

Middleware::requireLogin(); // << nueva línea justo después de incluir todo

// Mostrar errores en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload de clases de Controllers, Models y Config
spl_autoload_register(function ($class) {
    $paths = ['Controllers/', 'Models/', 'Config/'];
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Obtener URL limpia
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = str_replace('-', '', $url); // elimina guiones
$params = explode('/', $url);

// Controlador por defecto: Main
$controllerName = !empty($params[0]) ? ucfirst($params[0]) : 'Home';
$methodName = $params[1] ?? 'index';

// Comprobar si existe el controlador
$controllerFile = __DIR__ . '/Controllers/' . $controllerName . '.php';
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerName)) {
        $controller = new $controllerName();

        // Verificar si el método existe
        if (method_exists($controller, $methodName)) {
            unset($params[0], $params[1]); // Quitar controlador y método de parámetros
            $controller->$methodName(...$params);
        } else {
            http_response_code(404);
            echo "<h1>Error 404</h1><p>Método '$methodName' no encontrado en el controlador '$controllerName'.</p>";
        }
    } else {
        http_response_code(500);
        echo "<h1>Error</h1><p>La clase '$controllerName' no está definida.</p>";
    }
} else {
    http_response_code(404);
    echo "<h1>Error 404</h1><p>Controlador '$controllerName' no encontrado.</p>";
}
