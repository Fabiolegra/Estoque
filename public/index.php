<?php
// Arquivo de entrada principal
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Model.php';

// Roteamento simples
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Produto';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

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
