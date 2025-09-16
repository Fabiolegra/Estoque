<?php
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Model.php';
// Debug: exibir erros para diagnosticar "tela branca"
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$controller = $_GET['controller'] ?? 'Usuario';
$action = $_GET['action'] ?? 'login';

$controllerName = $controller . 'Controller';
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $obj = new $controllerName();
    if (method_exists($obj, $action)) {
        try {
            $obj->$action();
        } catch (Throwable $e) {
            http_response_code(500);
            echo '<pre style="color:red">Erro inesperado: ' . htmlspecialchars($e->getMessage()) . '</pre>';
        }
    } else {
        echo "Ação não encontrada.";
    }
} else {
    echo "Controlador não encontrado.";
}
