<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Produto.php';

class AdicionarProdutoController extends Controller {

    // Mostra o formulário de cadastro
    public function index() {
        $this->view('produtos/adicionar');
    }

    // Salva o novo produto no banco
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome' => $_POST['nome'] ?? '',
                'categoria' => $_POST['categoria'] ?? '',
                'quantidade' => $_POST['quantidade'] ?? 0,
                'quantidade_minima' => $_POST['quantidade_minima'] ?? 0,
                'preco' => $_POST['preco'] ?? 0
            ];

            $produto = new Produto();
            $produto->create($data);

            // Redireciona para o dashboard após salvar
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }
    }
}
