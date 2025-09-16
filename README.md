# Estoque - Sistema de Controle de Estoque (PHP + MySQL)

Sistema simples de controle de estoque em PHP (MVC leve) usando MySQL (PDO) e TailwindCSS para o front-end das views.

## Sumário
- Visão geral
- Tecnologias
- Arquitetura & Estrutura
- Requisitos
- Instalação
- Configuração do Banco de Dados
- Populando o Banco (opcional)
- Executando o Projeto
- Fluxos Principais
- Rotas Disponíveis
- Modelagem do Banco
- Convenções & Segurança
- Roadmap / TODO

## Visão geral
Permite cadastro de usuários, autenticação, cadastro/edição/exclusão de produtos, visualização de dashboard com estatísticas, listagem e movimentos (quando tabela existir). As views utilizam Tailwind para layout responsivo básico.

## Tecnologias
- PHP 7.4+ (PDO)
- MySQL 5.7+/8+
- TailwindCSS via CDN
- Estrutura MVC leve (Controller, Model, Views)

## Arquitetura & Estrutura
```
app/
  controllers/
    AdicionarProdutoController.php
    DashboardController.php
    ProdutoController.php
    UsuarioController.php
  core/
    Controller.php
    Database.php
    Model.php
  models/
    Produto.php
    Usuario.php
    schema.sql
  views/
    dashboard/index.php
    produtos/
      adicionar.php
      editar.php
      index.php
    usuarios/
      cadastro.php
      login.php
config/
  config.php
public/
  index.php (front controller)
```

- public/index.php: roteia a requisição via query string ?controller=...&action=...
- Controller base: renderiza views (require da view e extract dos dados)
- Model base: instancia PDO via Database

## Requisitos
- PHP 7.4+ com extensão pdo_mysql habilitada
- MySQL
- Servidor web (Apache/Nginx) ou PHP embutido
- Opcional: XAMPP/WAMP para ambiente local

## Instalação
1) Clonar/copiar o projeto em seu servidor (por exemplo, htdocs/Estoque).
2) Ajustar as permissões se necessário (logs em storage, se utilizados).

## Configuração do Banco de Dados
1) Edite config/config.php com seus dados:
```
return [
    'host' => 'localhost',
    'dbname' => 'estoque',
    'user' => 'root',
    'password' => '',
];
```
2) Crie o banco `estoque` se ainda não existir.
3) Importe o schema principal: app/models/schema.sql (contém tabelas categorias, fornecedores, usuarios, produtos, movimentos e alguns inserts de exemplo).
   - Via terminal: `mysql -u root -p estoque < app/models/schema.sql`
   - Ou via phpMyAdmin (Import -> selecione o arquivo).

Observação: existe também app/models/create_produtos_table.sql (simplificado). Prefira schema.sql para o ambiente completo.

## Populando o Banco (opcional)
O arquivo schema.sql inclui inserts de exemplo para categorias, fornecedores, produtos e movimentos.

## Executando o Projeto
- Via Apache (ex.: XAMPP): acesse http://localhost/Estoque/public/index.php
- Via PHP embutido: dentro da raiz do projeto, execute
```
php -S localhost:8000 -t public
```
Acesse http://localhost:8000

## Fluxos Principais
- Autenticação
  - Cadastro: index.php?controller=Usuario&action=cadastro (POST: nome, email, senha)
  - Login: index.php?controller=Usuario&action=login (POST: email, senha)
  - Logout: index.php?controller=Usuario&action=logout
  - Após login, redireciona para Dashboard.

- Dashboard
  - Rota: index.php?controller=Dashboard&action=index
  - Exibe estatísticas (total, críticos, baixa, excesso, novos), lista de produtos e movimentos recentes (quando tabela existir).
  - Busca (GET): index.php?controller=Dashboard&action=search&q=...

- Produtos
  - Listagem: index.php?controller=Produto&action=index
  - Adicionar (form): index.php?controller=AdicionarProduto&action=index
  - Salvar (POST): index.php?controller=AdicionarProduto&action=salvar
  - Editar (form): index.php?controller=Produto&action=editar&id={id}
  - Atualizar (POST): index.php?controller=Produto&action=atualizar
  - Excluir (GET): index.php?controller=Produto&action=excluir&id={id}
  - Após atualizar/excluir: redireciona para Dashboard.

## Rotas Disponíveis (resumo)
- Usuario: cadastro, login, logout
- Dashboard: index, search, searchAll (JSON), stats (JSON)
- Produto: index, adicionar, salvar, editar, atualizar, excluir
- AdicionarProduto: index, salvar

## Modelagem do Banco (resumo do schema.sql)
- categorias (id, nome, descricao, criado_at)
- fornecedores (id, nome, contato, email, telefone, criado_at)
- usuarios (id, nome, email, senha, papel, criado_at)
- produtos (
    id, nome, descricao, categoria_id, fornecedor_id, quantidade, quantidade_minima, preco,
    criado_at, atualizado_at, índices e FKs para categorias/fornecedores
  )
- movimentos (id, produto_id, tipo, quantidade, observacao, created_at)

Observações:
- FKs: produtos.categoria_id -> categorias.id (ON DELETE SET NULL), produtos.fornecedor_id -> fornecedores.id (ON DELETE SET NULL)
- As views de cadastro/edição já contemplam descricao, categoria_id, fornecedor_id.
- No create atual, o backend ainda usa uma coluna `categoria` (texto) para compatibilidade. Ajuste recomendado abaixo.

## Convenções & Segurança
- PDO com ERRMODE_EXCEPTION
- Password hashing: password_hash/password_verify
- Escapes nas views com htmlspecialchars
- Confirme IDs de categoria/fornecedor ou deixe em branco para NULL (evita violação de FK)
- Sessão é verificada no Dashboard (redireciona para login se não autenticado)

## Ajustes Recomendados (alinhamento ao schema.sql)
- app/models/Produto.php
  - create(): migrar para inserir conforme schema.sql
    - INSERT INTO produtos (nome, descricao, categoria_id, fornecedor_id, quantidade, quantidade_minima, preco)
    - Fazer bind de categoria_id/fornecedor_id como NULL quando vazio/0
- app/controllers/AdicionarProdutoController.php
  - salvar(): coletar descricao, categoria_id, fornecedor_id e repassar ao model conforme acima

Esses ajustes alinham totalmente a persistência ao schema.sql e evitam dependência da coluna `categoria` simples.

## Roadmap / TODO
- Implementar models Categoria e Fornecedor + controllers e CRUD completo
- Popular selects de categoria/fornecedor nas views a partir do banco
- Paginação da listagem de produtos
- Validações server-side mais robustas
- Logs centralizados (mover writes para storage/ com verificação de permissão)
- Testes automatizados (PHPUnit)
- Internacionalização e mensagens centralizadas

## Licença
Projeto educacional/exemplo. Adapte livremente conforme sua necessidade.
