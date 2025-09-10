<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cadastrar Produto - Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="text-xl font-bold">Estoque</div>
            <div class="text-sm text-gray-500">Cadastro de Produto</div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="index.php?controller=Dashboard&action=index" class="bg-blue-600 text-white px-3 py-2 rounded">Voltar</a>
            <a href="index.php?controller=Usuario&action=logout" class="text-red-500">Sair</a>
        </div>
    </div>
</nav>

<div class="max-w-3xl mx-auto mt-6 bg-white rounded shadow p-6">
    <h2 class="text-2xl font-semibold mb-4">Cadastrar Novo Produto</h2>
    <form action="index.php?controller=Produto&action=salvar" method="post" class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-1" for="nome">Nome do Produto</label>
            <input type="text" name="nome" id="nome" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" for="categoria">Categoria</label>
            <input type="text" name="categoria" id="categoria"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" for="quantidade">Quantidade</label>
                <input type="number" name="quantidade" id="quantidade" min="0" required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" for="quantidade_minima">Quantidade Mínima</label>
                <input type="number" name="quantidade_minima" id="quantidade_minima" min="0"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" for="preco">Preço Unitário (R$)</label>
            <input type="number" step="0.01" name="preco" id="preco" min="0"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex justify-end space-x-2">
            <button type="reset" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Limpar</button>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Cadastrar</button>
        </div>
    </form>
</div>

</body>
</html>
