<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Produto.php';

class ProdutoController extends Controller {

    // Lista todos os produtos
    public function index() {
        $produtos = (new Produto())->getAll();
        $this->view('produtos/index', ['produtos' => $produtos]);
    }

    // Abre formulário de cadastro
    public function adicionar() {
        $this->view('produtos/adicionar');
    }

    // Salva produto no banco
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nome' => $_POST['nome'],
                'categoria' => $_POST['categoria'],
                'quantidade' => $_POST['quantidade'],
                'quantidade_minima' => $_POST['quantidade_minima'],
                'preco' => $_POST['preco']
            ];

            $produto = new Produto();
            if ($produto->create($data)) {
                header('Location: index.php?controller=Produto&action=index');
                exit;
            } else {
                echo "Erro ao cadastrar produto!";
            }
        }
    }
}
