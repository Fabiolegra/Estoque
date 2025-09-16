<!DOCTYPE html>
<html lang="pt-br">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Dashboard - Estoque</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="text-xl font-bold">Estoque</div>
            <div class="text-sm text-gray-500">Painel de Controle</div>
        </div>
        <div class="flex items-center space-x-3">
            <form action="index.php?controller=Dashboard&action=search" method="get" class="hidden md:block">
                <input type="text" name="q" placeholder="Pesquisar produtos..." class="border rounded px-3 py-2" />
                <button class="ml-2 bg-blue-600 text-white px-3 py-2 rounded">Buscar</button>
            </form>
            <a href="index.php?controller=Usuario&action=logout" class="text-red-500">Sair</a>
        </div>
    </div>
</nav>

<?php if (!empty($error)): ?>
    <div class="max-w-7xl mx-auto p-4">
        <div class="p-3 bg-red-50 border-l-4 border-red-400 text-red-700 rounded"><?php echo htmlspecialchars($error); ?></div>
    </div>
<?php endif; ?>

<?php if (!empty($search_results)): ?>
    <div class="max-w-7xl mx-auto p-4">
        <h3 class="text-xl font-semibold mt-6">Resultados da busca: <?php echo htmlspecialchars($q ?? ''); ?></h3>
        <div class="mt-4">
            <ul class="list-disc list-inside">
                <?php foreach ($search_results as $result): ?>
                    <li><?php echo htmlspecialchars($result['nome'] ?? ''); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<div class="max-w-7xl mx-auto p-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Total de produtos</div>
            <div class="text-2xl font-bold"><?php echo $stats['total'] ?? 0; ?></div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Produtos críticos</div>
            <div class="text-2xl font-bold text-red-600"><?php echo $stats['criticos'] ?? 0; ?></div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Produtos em baixa</div>
            <div class="text-2xl font-bold text-yellow-600"><?php echo $stats['baixa'] ?? 0; ?></div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Produtos novos (30d)</div>
            <div class="text-2xl font-bold text-green-600"><?php echo $stats['novos'] ?? 0; ?></div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="col-span-2 bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-3">Movimentos recentes</h3>
            <div class="space-y-2">
                <?php if (!empty($recent)): ?>
                    <?php foreach ($recent as $mov): ?>
                        <div class="flex items-center justify-between p-2 border rounded">
                            <div>
                                <div class="font-medium"><?php echo htmlspecialchars($mov['nome'] ?? ''); ?></div>
                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars(($mov['tipo'] ?? '')) . ' • ' . htmlspecialchars((string)($mov['quantidade'] ?? '')); ?></div>
                            </div>
                            <div class="text-sm text-gray-400"><?php echo htmlspecialchars($mov['created_at'] ?? ''); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-gray-500">Nenhum movimento registrado.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-3">Alertas</h3>
            <?php if (($stats['criticos'] ?? 0) > 0): ?>
                <div class="p-3 bg-red-50 border-l-4 border-red-400 text-red-700 rounded">Há produtos com estoque crítico.</div>
            <?php else: ?>
                <div class="p-3 bg-green-50 border-l-4 border-green-400 text-green-700 rounded">Estoque estável.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-6 bg-white rounded shadow p-4">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold">Produtos</h3>
            <div class="flex items-center space-x-2">
                <a href="index.php?controller=AdicionarProduto&action=index" class="bg-green-600 text-white px-3 py-1 rounded">Adicionar</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nome</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Categoria</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Qtd</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Mín</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Preço</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach (($produtos ?? []) as $p): ?>
                        <tr>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($p['nome'] ?? ''); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($p['categoria'] ?? ''); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars((string)($p['quantidade'] ?? 0)); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars((string)($p['quantidade_minima'] ?? '')); ?></td>
                            <td class="px-4 py-2">R$ <?php echo number_format((float)($p['preco'] ?? 0), 2, ',', '.'); ?></td>
                            <td class="px-4 py-2">
                                <?php if (isset($p['quantidade_minima']) && isset($p['quantidade']) && (int)$p['quantidade'] <= (int)$p['quantidade_minima']): ?>
                                    <span class="text-red-600 font-semibold">Crítico</span>
                                <?php else: ?>
                                    <span class="text-green-600 font-semibold">Ok</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <a href="index.php?controller=Produto&action=ver&id=<?php echo urlencode((string)($p['id'] ?? '')); ?>" class="text-blue-600 mr-2">Ver</a>
                                <a href="index.php?controller=Produto&action=editar&id=<?php echo urlencode((string)($p['id'] ?? '')); ?>" class="text-yellow-600 mr-2">Editar</a>
                                <a href="index.php?controller=Produto&action=excluir&id=<?php echo urlencode((string)($p['id'] ?? '')); ?>" class="text-red-600">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>
