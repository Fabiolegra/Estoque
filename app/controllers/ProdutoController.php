<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Produto.php';

class ProdutoController extends Controller {
    public function index() {
        $produtos = (new Produto())->getAll();
        $this->view('produtos/index', ['produtos' => $produtos]);
    }
}
