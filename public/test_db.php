<?php
require_once __DIR__ . '/../app/core/Database.php';
try {
    $db = new Database();
    $conn = $db->getConnection();
    echo '<div style="color:green;font-weight:bold;">Conexão com o banco de dados bem-sucedida!</div>';
} catch (PDOException $e) {
    echo '<div style="color:red;font-weight:bold;">Erro na conexão: ' . $e->getMessage() . '</div>';
}
