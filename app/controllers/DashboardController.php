<?php
require_once __DIR__ . '/../core/Controller.php';
class DashboardController extends Controller {
    public function index() {
        session_start();
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?controller=Usuario&action=login');
            exit;
        }
        $this->view('dashboard/index');
    }
}
