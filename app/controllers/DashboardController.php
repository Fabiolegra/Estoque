<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Produto.php';

class DashboardController extends Controller {
    public function index() {
        session_start();
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?controller=Usuario&action=login');
            exit;
        }
        $produto = new Produto();
        $stats = $produto->getStats();
        $recent = $produto->getRecentMovements(20);
        $produtos = $produto->getAll(50, 0);
        $this->view('dashboard/index', ['stats' => $stats, 'recent' => $recent, 'produtos' => $produtos]);
    }

    // endpoint JSON para busca rápida
    public function search() {
        $q = $_GET['q'] ?? '';
        $produto = new Produto();
        $res = $produto->search($q, 50);
        header('Content-Type: application/json');
        echo json_encode($res);
    }

    // endpoint JSON para estatísticas
    public function stats() {
        $produto = new Produto();
        header('Content-Type: application/json');
        echo json_encode($produto->getStats());
    }
}
