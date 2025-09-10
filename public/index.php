<?php
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Model.php';

$controller = $_GET['controller'] ?? 'Usuario';
$action = $_GET['action'] ?? 'login';

$controllerName = $controller . 'Controller';
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $obj = new $controllerName();
    if (method_exists($obj, $action)) {
        $obj->$action();
    } else {
        echo "Ação não encontrada.";
    }
} else {
    echo "Controlador não encontrado.";
}
