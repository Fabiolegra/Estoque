<h1>Dashboard de Produtos</h1>
<a href="index.php?controller=Produto&action=adicionar">Adicionar Produto</a>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Fornecedor</th>
        <th>Quantidade</th>
        <th>Preço</th>
        <th>Ações</th>
    </tr>
    <?php foreach($produtos as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['nome'] ?></td>
        <td><?= $p['categoria_id'] ?></td>
        <td><?= $p['fornecedor_id'] ?></td>
        <td><?= $p['quantidade'] ?></td>
        <td><?= $p['preco'] ?></td>
        <td>
            <a href="index.php?controller=Produto&action=editar&id=<?= $p['id'] ?>">Editar</a> |
            <a href="index.php?controller=Produto&action=excluir&id=<?= $p['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
