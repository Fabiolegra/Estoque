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
        $stats = ['total' => 0, 'criticos' => 0, 'novos' => 0, 'excesso' => 0, 'baixa' => 0];
        $recent = [];
        $produtos = [];
        $error = null;
        try {
            $produto = new Produto();
            $stats = $produto->getStats();
            $recent = $produto->getRecentMovements(20);
            $produtos = $produto->getAll(50, 0);
        } catch (Exception $e) {
            $error = 'Erro ao carregar dados do dashboard: ' . $e->getMessage();
        }
        $this->view('dashboard/index', ['stats' => $stats, 'recent' => $recent, 'produtos' => $produtos, 'error' => $error]);
    }

    // ação para busca via formulário do dashboard (HTML)
    public function search() {
        session_start();
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?controller=Usuario&action=login');
            exit;
        }
        $q = $_GET['q'] ?? '';
        $search_results = [];
        $stats = ['total' => 0, 'criticos' => 0, 'novos' => 0, 'excesso' => 0, 'baixa' => 0];
        $recent = [];
        $produtos = [];
        $error = null;
        try {
            $produto = new Produto();
            $search_results = $produto->search($q, 50);
            $stats = $produto->getStats();
            $recent = $produto->getRecentMovements(20);
            $produtos = $produto->getAll(50, 0);
        } catch (Exception $e) {
            $error = 'Erro ao carregar dados do dashboard: ' . $e->getMessage();
        }
        $this->view('dashboard/index', [
            'stats' => $stats,
            'recent' => $recent,
            'produtos' => $produtos,
            'search_results' => $search_results,
            'q' => $q,
            'error' => $error,
        ]);
    }

    // endpoint JSON para busca rápida
    public function searchAll() {
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
