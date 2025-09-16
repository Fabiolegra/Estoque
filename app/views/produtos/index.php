<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produtos - Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="text-xl font-bold">Estoque</div>
            <div class="text-sm text-gray-500">Lista de Produtos</div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="index.php?controller=Dashboard&action=index" class="text-gray-600 hover:text-gray-900">Dashboard</a>
            <a href="index.php?controller=Usuario&action=logout" class="text-red-500">Sair</a>
        </div>
    </div>
</nav>

<div class="max-w-7xl mx-auto mt-6 px-4">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-semibold">Produtos</h2>
        <a href="index.php?controller=Produto&action=adicionar"
           class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Adicionar Produto
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aç��es</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                <?php if (!empty($produtos)): ?>
                    <?php foreach ($produtos as $p): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-600"><?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900"><?= htmlspecialchars($p['nome'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <?= isset($p['categoria_id']) && $p['categoria_id'] !== null && $p['categoria_id'] !== ''
                                    ? htmlspecialchars($p['categoria_id'], ENT_QUOTES, 'UTF-8')
                                    : '—'; ?>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <?= isset($p['fornecedor_id']) && $p['fornecedor_id'] !== null && $p['fornecedor_id'] !== ''
                                    ? htmlspecialchars($p['fornecedor_id'], ENT_QUOTES, 'UTF-8')
                                    : '—'; ?>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    <?php
                                        $q = (int)($p['quantidade'] ?? 0);
                                        $qm = (int)($p['quantidade_minima'] ?? 0);
                                        echo ($q <= $qm) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800';
                                    ?>">
                                    <?= htmlspecialchars((string)($p['quantidade'] ?? 0), ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <?php
                                    $preco = isset($p['preco']) ? (float)$p['preco'] : 0;
                                    echo 'R$ ' . number_format($preco, 2, ',', '.');
                                ?>
                            </td>
                            <td class="px-4 py-3 text-right text-sm">
                                <a class="text-blue-600 hover:text-blue-800 mr-3"
                                   href="index.php?controller=Produto&action=editar&id=<?= urlencode($p['id']); ?>">Editar</a>
                                <a class="text-red-600 hover:text-red-800"
                                   href="index.php?controller=Produto&action=excluir&id=<?= urlencode($p['id']); ?>"
                                   onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">Nenhum produto cadastrado.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
