<?php
require_once __DIR__ . '/../core/Model.php';
class Produto extends Model {
    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM produtos');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
