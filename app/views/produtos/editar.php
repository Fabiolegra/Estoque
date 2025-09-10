<h1>Editar Produto</h1>
<form method="POST" action="index.php?controller=Produto&action=atualizar">
    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
    Nome: <input type="text" name="nome" value="<?= $produto['nome'] ?>"><br>
    Descrição: <input type="text" name="descricao" value="<?= $produto['descricao'] ?>"><br>
    Categoria:
    <select name="categoria_id">
        <?php foreach($categorias as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $produto['categoria_id'] == $c['id'] ? 'selected' : '' ?>><?= $c['nome'] ?></option>
        <?php endforeach; ?>
    </select><br>
    Fornecedor:
    <select name="fornecedor_id">
        <?php foreach($fornecedores as $f): ?>
            <option value="<?= $f['id'] ?>" <?= $produto['fornecedor_id'] == $f['id'] ? 'selected' : '' ?>><?= $f['nome'] ?></option>
        <?php endforeach; ?>
    </select><br>
    Quantidade: <input type="number" name="quantidade" value="<?= $produto['quantidade'] ?>"><br>
    Quantidade mínima: <input type="number" name="quantidade_minima" value="<?= $produto['quantidade_minima'] ?>"><br>
    Preço: <input type="text" name="preco" value="<?= $produto['preco'] ?>"><br>
    <button type="submit">Salvar</button>
</form>
