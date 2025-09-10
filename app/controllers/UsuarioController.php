<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Usuario.php';


class UsuarioController extends Controller {
    public function cadastro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // debug log
            $log = __DIR__ . '/../../storage/logs/auth.log';
            file_put_contents($log, "[cadastro] POST data: " . json_encode($_POST) . "\n", FILE_APPEND);
            $usuario = new Usuario();
            try {
                if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha'])) {
                    throw new Exception('Preencha todos os campos.');
                }
                $ok = $usuario->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha']);
                        if ($ok) {
                            file_put_contents($log, "[cadastro] registro inserido\n", FILE_APPEND);
                            header('Location: index.php?controller=Usuario&action=login');
                            exit;
                        } else {
                            $erro = 'Erro ao cadastrar usuário.';
                            file_put_contents($log, "[cadastro] execute retornou false\n", FILE_APPEND);
                        }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $erro = 'E-mail já cadastrado.';
                } else {
                    $erro = 'Erro no banco de dados: ' . $e->getMessage();
                }
                file_put_contents($log, "[cadastro] PDOException: " . $e->getMessage() . "\n", FILE_APPEND);
            } catch (Exception $e) {
                $erro = $e->getMessage();
                file_put_contents($log, "[cadastro] Exception: " . $e->getMessage() . "\n", FILE_APPEND);
            }
        }
        $this->view('usuarios/cadastro', isset($erro) ? ['erro' => $erro] : []);
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $log = __DIR__ . '/../../storage/logs/auth.log';
            file_put_contents($log, "[login] POST data: " . json_encode($_POST) . "\n", FILE_APPEND);
            $usuario = new Usuario();
            $user = $usuario->autenticar($_POST['email'], $_POST['senha']);
            if ($user) {
                file_put_contents($log, "[login] autenticado: user_id=" . $user['id'] . "\n", FILE_APPEND);
                session_start();
                $_SESSION['usuario'] = $user;
                header('Location: index.php?controller=Dashboard&action=index');
                exit;
            } else {
                $erro = 'Usuário ou senha inválidos.';
                file_put_contents($log, "[login] falha autenticacao\n", FILE_APPEND);
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
