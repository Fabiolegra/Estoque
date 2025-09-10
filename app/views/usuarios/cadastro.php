<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded shadow">
        <h2 class="text-xl font-bold mb-6">Cadastro de Usuário</h2>
        <?php if (!empty($erro)): ?>
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"> <?php echo $erro; ?> </div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-4">
                <label class="block mb-1">Nome</label>
                <input type="text" name="nome" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Senha</label>
                <input type="password" name="senha" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cadastrar</button>
        </form>
        <a href="login.php" class="block mt-4 text-blue-600">Já tem conta? Faça login</a>
    </div>
</body>
</html>
