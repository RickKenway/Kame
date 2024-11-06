<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Receita</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            align-items: center;
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
            position: relative;
        }

        header::after {
            content: "";
            display: block;
            width: 100%;
            height: 4px;
            background-color: #42392a;
            margin-top: 10px;
        }

        /* Estilo do formulário */
        form {
            background-color: #fae5ad;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #42392a;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
            color: #42392a;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Estilo dos botões */
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

        .botao-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        /* Estilo do rodapé */
        footer {
            background-color: #fae5ad;
            color: #42392a;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Cadastrar Receita</h1>
    </header>

    <h2>Cadastrar Nova Receita</h2>
    <form action="actions/cadastrar_receita_action.php" method="POST">
        <label for="nome">Nome da Receita:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea>

        <label for="custo_estimado">Custo Estimado:</label>
        <input type="number" id="custo_estimado" name="custo_estimado" step="0.01" required>

        <div class="botao-container">
            <button type="submit" class="btn">
                <i class="fas fa-check"></i> Salvar Receita
            </button>
            <a href="index.php" class="btn">
                <i class="fas fa-undo"></i> Voltar
            </a>
        </div>
    </form>

    <footer>
        <p>&copy; 2024 Sistema de Gerenciamento de Receitas</p>
    </footer>
</body>
</html>
