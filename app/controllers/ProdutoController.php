<?php
require_once __DIR__ . '/../core/Database.php';

class Produto {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); // Conexão PDO
    }

    // Retorna todos os produtos
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM produtos ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cria um novo produto
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO produtos (nome, categoria, quantidade, quantidade_minima, preco)
            VALUES (:nome, :categoria, :quantidade, :quantidade_minima, :preco)
        ");
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':categoria', $data['categoria']);
        $stmt->bindParam(':quantidade', $data['quantidade']);
        $stmt->bindParam(':quantidade_minima', $data['quantidade_minima']);
        $stmt->bindParam(':preco', $data['preco']);
        return $stmt->execute();
    }
}
