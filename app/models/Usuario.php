<?php
require_once __DIR__ . '/../core/Model.php';
class Usuario extends Model {
    public function cadastrar($nome, $email, $senha) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)');
        return $stmt->execute([$nome, $email, $hash]);
    }
    public function autenticar($email, $senha) {
        $stmt = $this->db->prepare('SELECT * FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }
}
