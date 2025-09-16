<?php
require_once __DIR__ . '/../core/Model.php';
class Produto extends Model {
    // Retorna todos os produtos (com paginação opcional)
    public function getAll($limit = 100, $offset = 0, $filters = []) {
        // construção simples de WHERE com filtros permitidos
        $where = [];
        $params = [];
        if (!empty($filters['categoria'])) {
            $where[] = 'categoria = ?';
            $params[] = $filters['categoria'];
        }
        if (!empty($filters['fornecedor'])) {
            $where[] = 'fornecedor = ?';
            $params[] = $filters['fornecedor'];
        }
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'critico') {
                $where[] = 'quantidade <= quantidade_minima';
            } elseif ($filters['status'] === 'seguro') {
                $where[] = 'quantidade > quantidade_minima';
            }
        }
        $sql = 'SELECT * FROM produtos';
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
    // LIMIT/OFFSET must be integers inserted directly to avoid driver binding them as strings
    $sql .= ' ORDER BY id DESC LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Estatísticas gerais
    public function getStats() {
        $stats = [
            'total' => 0,
            'criticos' => 0,
            'novos' => 0,
            'excesso' => 0,
            'baixa' => 0,
        ];
        // total
        $stmt = $this->db->query('SELECT COUNT(*) as c FROM produtos');
        $stats['total'] = (int)$stmt->fetchColumn();

        // verificar se coluna quantidade_minima existe
        $cols = $this->getColumns();
        if (in_array('quantidade_minima', $cols) && in_array('criado_at', $cols)) {
            $stmt = $this->db->query('SELECT COUNT(*) FROM produtos WHERE quantidade <= quantidade_minima');
            $stats['criticos'] = (int)$stmt->fetchColumn();

            $stmt = $this->db->query('SELECT COUNT(*) FROM produtos WHERE quantidade < quantidade_minima * 2');
            $stats['baixa'] = (int)$stmt->fetchColumn();

            $stmt = $this->db->query('SELECT COUNT(*) FROM produtos WHERE quantidade > quantidade_minima * 10');
            $stats['excesso'] = (int)$stmt->fetchColumn();

            $stmt = $this->db->prepare('SELECT COUNT(*) FROM produtos WHERE criado_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)');
            $stmt->execute();
            $stats['novos'] = (int)$stmt->fetchColumn();
        }

        return $stats;
    }

    // Busca rápida por nome
    public function search($q, $limit) {
        $stmt = $this->db->prepare("SELECT * FROM produtos WHERE nome LIKE :q LIMIT :limit");
        $stmt->bindValue(':q', "%$q%");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // retorna colunas da tabela produtos
    private function getColumns() {
        $stmt = $this->db->query("SHOW COLUMNS FROM produtos");
        $cols = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $cols ?: [];
    }

    // Retorna movimentos recentes se tabela existir
    public function getRecentMovements($limit = 50) {
        // movimentos table: movimentos (id, produto_id, tipo, quantidade, created_at)
        $res = [];
        try {
            $stmt = $this->db->query('SELECT m.*, p.nome FROM movimentos m LEFT JOIN produtos p ON p.id = m.produto_id ORDER BY m.created_at DESC LIMIT ' . (int)$limit);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // tabela pode não existir
        }
        return $res;
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

    // Retorna produto por ID
public function getById($id) {
    $stmt = $this->db->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Atualiza produto
public function update($data) {
    $stmt = $this->db->prepare("
        UPDATE produtos SET
            nome = :nome,
            descricao = :descricao,
            categoria_id = :categoria_id,
            fornecedor_id = :fornecedor_id,
            quantidade = :quantidade,
            quantidade_minima = :quantidade_minima,
            preco = :preco
        WHERE id = :id
    ");
    $stmt->bindParam(':id', $data['id']);
    $stmt->bindParam(':nome', $data['nome']);
    $stmt->bindParam(':descricao', $data['descricao']);
    $stmt->bindParam(':categoria_id', $data['categoria_id']);
    $stmt->bindParam(':fornecedor_id', $data['fornecedor_id']);
    $stmt->bindParam(':quantidade', $data['quantidade']);
    $stmt->bindParam(':quantidade_minima', $data['quantidade_minima']);
    $stmt->bindParam(':preco', $data['preco']);
    return $stmt->execute();
}

// Excluir produto
public function delete($id) {
    $stmt = $this->db->prepare("DELETE FROM produtos WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}}
?>
