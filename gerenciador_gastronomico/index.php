<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Principal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <style>
        /* Estilo global */
        body {
            background-color: #B09779;
            color: #fae5ad;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Estilo do cabeçalho */
        header {
            background-color: #fae5ad;
            color: #42392a;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Estilo dos títulos */
        h2 {
            color: #42392a;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Estilos para os botões */
        .btn {
            background-color: #887b66;
            color: #42392a;
            padding: 15px 25px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #42392a;
            color: #fae5ad;
        }

        /* Estilos para o nav */
        nav {
            margin-top: 20px;
            text-align: center;
            flex-grow: 1;
        }

        .btn-sair {
            padding: 8px 15px;
            font-size: 16px;
            position: absolute;
            right: 20px;
            top: 20px;
            background-color: #fae5ad;
            color: #42392a;
        }

        /* Estilo do rodapé */
        footer {
            background-color: #fae5ad;
            color: #42392a;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Painel Principal</h1>
        <a href="logout.php" class="btn-sair">Sair</a> <!-- Botão de sair no topo -->
    </header>

    <!-- Exibe a função do usuário -->
    <h2>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>
    <p style="text-align: center;">Função: <?php echo htmlspecialchars($_SESSION['tipo_usuario']); ?></p>
    
    <nav>
        <a href="cadastro_receita.php" class="btn">
            <i class="fas fa-utensils"></i> Cadastrar Receita
        </a>
        <a href="listar_receitas.php" class="btn">
            <i class="fas fa-list"></i> Listar Receitas
        </a>
        <a href="listar_estoque.php" class="btn">
            <i class="fas fa-boxes"></i> Gerenciar Estoque
        </a>
    </nav>
    
    <footer>
        <p>&copy; 2024 Sistema de Gerenciamento</p>
    </footer>
</body>
</html>
