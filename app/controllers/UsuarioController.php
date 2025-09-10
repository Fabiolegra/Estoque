<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController extends Controller {
    public function cadastro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario();
            $ok = $usuario->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha']);
            if ($ok) {
                header('Location: index.php?controller=Usuario&action=login');
                exit;
            } else {
                $erro = 'Erro ao cadastrar usuário.';
            }
        }
        $this->view('usuarios/cadastro', isset($erro) ? ['erro' => $erro] : []);
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario();
            $user = $usuario->autenticar($_POST['email'], $_POST['senha']);
            if ($user) {
                session_start();
                $_SESSION['usuario'] = $user;
                header('Location: index.php');
                exit;
            } else {
                $erro = 'Usuário ou senha inválidos.';
            }
        }
        $this->view('usuarios/login', isset($erro) ? ['erro' => $erro] : []);
    }
    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?controller=Usuario&action=login');
        exit;
    }
}
