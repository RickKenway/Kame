<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Novo Ingrediente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Link do Font Awesome -->
    <style>
        /* Estilo global */
        body {
            background-color: #B09779;
            color: #fae5ad;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        /* Estilo do cabeçalho */
        header {
            background-color: #fae5ad;
            color: #42392a;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 600px;
        }

        header h2 {
            margin: 0;
        }

        /* Estilo do formulário */
        form {
            background-color: #fae5ad;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
        }

        label {
            font-weight: bold;
            color: #42392a;
            margin-top: 10px;
            width: 100%;
            text-align: left;
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            color: #42392a;
        }

        input[type="text"]:focus, input[type="number"]:focus, select:focus {
            border-color: #887b66;
            outline: none;
        }

        /* Estilos para os botões */
        .btn {
            background-color: #887b66;
            color: #42392a;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin: 10px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #42392a;
            color: #fae5ad;
        }

        /* Estilo do rodapé */
        footer {
            background-color: #fae5ad;
            color: #42392a;
            text-align: center;
            padding: 10px 0;
            width: 100%; /* Ocupa toda a largura da tela */
            position: fixed; /* Fixa o rodapé na parte inferior */
            bottom: 0; /* Posiciona no final da tela */
            left: 0;
        }
    </style>
</head>
<body>
    <header>
        <h2>Cadastrar Novo Ingrediente</h2>
    </header>
    
    <form method="POST" action="actions/cadastrar_ingrediente_action.php">
        <label for="nome">Nome do Ingrediente:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="quantidade">Quantidade Inicial:</label>
        <input type="number" id="quantidade" name="quantidade" step="0.01" required>

        <label for="unidade">Unidade:</label>
        <select id="unidade" name="unidade" required>
            <option value="" disabled selected>Selecione uma unidade</option>
            <option value="kg">Kilograma (kg)</option>
            <option value="g">Grama (g)</option>
            <option value="l">Litro (l)</option>
            <option value="ml">Mililitro (ml)</option>
            <option value="unidade">Unidade (unidade)</option>
        </select>

        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="btn">
                <i class="fas fa-check"></i> Salvar Ingrediente
            </button>
            <a href="listar_estoque.php" class="btn">
                <i class="fas fa-undo"></i> Voltar
            </a>
        </div>
    </form>

    <footer>
        &copy; 2024 Sistema de Gerenciamento de Estoque
    </footer>
</body>
</html>
