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

    // Exibir formulário de edição
    public function editar() {
        $id = $_GET['id'];
        $produto = (new Produto())->getById($id);
        //$categorias = (new Categoria())->getAll();
       // $fornecedores = (new Fornecedor())->getAll();

        $this->view('produtos/editar', [
            'produto' => $produto,
            //'categorias' => $categorias,
            //'fornecedores' => $fornecedores
        ]);
    }

    // Atualizar produto
    public function atualizar() {
        $data = [
            'id' => $_POST['id'],
            'nome' => $_POST['nome'],
            'descricao' => $_POST['descricao'],
            'categoria_id' => $_POST['categoria_id'],
            'fornecedor_id' => $_POST['fornecedor_id'],
            'quantidade' => $_POST['quantidade'],
            'quantidade_minima' => $_POST['quantidade_minima'],
            'preco' => $_POST['preco']
        ];

        (new Produto())->update($data);
        header('Location: index.php?controller=Produto&action=index');
    }

    // Excluir produto
    public function excluir() {
        $id = $_GET['id'];
        (new Produto())->delete($id);
        header('Location: index.php?controller=Produto&action=index');
    }

}
