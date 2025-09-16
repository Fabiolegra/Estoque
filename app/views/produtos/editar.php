<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Produto - Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="text-xl font-bold">Estoque</div>
            <div class="text-sm text-gray-500">Edição de Produto</div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="index.php?controller=Produto&action=index" class="bg-blue-600 text-white px-3 py-2 rounded">Voltar</a>
            <a href="index.php?controller=Usuario&action=logout" class="text-red-500">Sair</a>
        </div>
    </div>
</nav>

<div class="max-w-3xl mx-auto mt-6 bg-white rounded shadow p-6">
    <div class="flex items-start justify-between">
        <h2 class="text-2xl font-semibold mb-4">Editar Produto</h2>
        <?php if (!empty($produto['nome'])): ?>
            <span class="text-sm text-gray-500 mt-1">#<?= htmlspecialchars($produto['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?> — <?= htmlspecialchars($produto['nome'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
        <?php endif; ?>
    </div>

    <form method="POST" action="index.php?controller=Produto&action=atualizar" class="space-y-4">
        <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

        <div>
            <label class="block text-sm font-medium mb-1" for="nome">Nome do Produto</label>
            <input type="text" id="nome" name="nome" required
                   value="<?= htmlspecialchars($produto['nome'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" rows="3"
                      class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($produto['descricao'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" for="categoria_nome">Categoria</label>
                <input type="text" id="categoria_nome" name="categoria_nome"
                       list="categorias-lista"
                       value="<?php
                            $categoriaNomeAtual = '';
                            if (isset($categorias) && is_array($categorias)) {
                                foreach ($categorias as $c) {
                                    if ((int)($produto['categoria_id'] ?? 0) === (int)$c['id']) { $categoriaNomeAtual = $c['nome']; break; }
                                }
                            }
                            echo htmlspecialchars($categoriaNomeAtual, ENT_QUOTES, 'UTF-8');
                       ?>"
                       placeholder="Digite ou selecione o nome da categoria"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <input type="hidden" id="categoria_id" name="categoria_id" value="<?= htmlspecialchars($produto['categoria_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                <?php if (isset($categorias) && is_array($categorias) && count($categorias) > 0): ?>
                    <datalist id="categorias-lista">
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?= htmlspecialchars($c['nome'], ENT_QUOTES, 'UTF-8'); ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                <?php else: ?>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="fornecedor_nome">Fornecedor</label>
                <input type="text" id="fornecedor_nome" name="fornecedor_nome"
                       list="fornecedores-lista"
                       value="<?php
                            $fornecedorNomeAtual = '';
                            if (isset($fornecedores) && is_array($fornecedores)) {
                                foreach ($fornecedores as $f) {
                                    if ((int)($produto['fornecedor_id'] ?? 0) === (int)$f['id']) { $fornecedorNomeAtual = $f['nome']; break; }
                                }
                            }
                            echo htmlspecialchars($fornecedorNomeAtual, ENT_QUOTES, 'UTF-8');
                       ?>"
                       placeholder="Digite ou selecione o nome do fornecedor"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <input type="hidden" id="fornecedor_id" name="fornecedor_id" value="<?= htmlspecialchars($produto['fornecedor_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                <?php if (isset($fornecedores) && is_array($fornecedores) && count($fornecedores) > 0): ?>
                    <datalist id="fornecedores-lista">
                        <?php foreach ($fornecedores as $f): ?>
                            <option value="<?= htmlspecialchars($f['nome'], ENT_QUOTES, 'UTF-8'); ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                    <p class="text-xs text-gray-500 mt-1">O ID correspondente será preenchido automaticamente.</p>
                <?php else: ?>
                
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" for="quantidade">Quantidade</label>
                <input type="number" id="quantidade" name="quantidade" min="0" required
                       value="<?= htmlspecialchars($produto['quantidade'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" for="quantidade_minima">Quantidade Mínima</label>
                <input type="number" id="quantidade_minima" name="quantidade_minima" min="0"
                       value="<?= htmlspecialchars($produto['quantidade_minima'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" for="preco">Preço Unitário (R$)</label>
            <input type="number" id="preco" name="preco" step="0.01" min="0"
                   value="<?= htmlspecialchars($produto['preco'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div class="flex justify-end space-x-2 pt-2">
            <a href="index.php?controller=Produto&action=index" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Salvar</button>
        </div>
    </form>
</div>

<?php if ((isset($categorias) && is_array($categorias) && count($categorias) > 0) || (isset($fornecedores) && is_array($fornecedores) && count($fornecedores) > 0)): ?>
<script>
(function(){
    // Mapeia nomes para IDs
    var categoriasMap = {};
    <?php if (isset($categorias) && is_array($categorias)): ?>
    categoriasMap = {
        <?php foreach ($categorias as $i => $c): ?>
        <?= json_encode((string)$c['nome']) ?>: <?= (int)$c['id'] ?><?= $i === array_key_last($categorias) ? '' : ',' ?>
        <?php endforeach; ?>
    };
    <?php endif; ?>

    var fornecedoresMap = {};
    <?php if (isset($fornecedores) && is_array($fornecedores)): ?>
    fornecedoresMap = {
        <?php foreach ($fornecedores as $i => $f): ?>
        <?= json_encode((string)$f['nome']) ?>: <?= (int)$f['id'] ?><?= $i === array_key_last($fornecedores) ? '' : ',' ?>
        <?php endforeach; ?>
    };
    <?php endif; ?>

    function bindNameToId(inputId, hiddenId, map) {
        var input = document.getElementById(inputId);
        var hidden = document.getElementById(hiddenId);
        if (!input || !hidden) return;
        function update(){
            var nome = input.value || '';
            if (Object.prototype.hasOwnProperty.call(map, nome)) {
                hidden.value = map[nome];
            } else {
                hidden.value = '';
            }
        }
        input.addEventListener('change', update);
        input.addEventListener('input', update);
    }

    bindNameToId('categoria_nome', 'categoria_id', categoriasMap);
    bindNameToId('fornecedor_nome', 'fornecedor_id', fornecedoresMap);
})();
</script>
<?php endif; ?>

</body>
</html>
