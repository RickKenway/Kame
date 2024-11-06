<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <style>
        /* Estilo global */
        body {
            background-color: #B09779; /* Cor de fundo */
            color: #fae5ad; /* Cor do texto */
            font-family: Arial, sans-serif; /* Fonte padrão */
            margin: 0; /* Remove margem padrão */
            padding: 20px; /* Adiciona padding ao corpo */
            display: flex; /* Flexbox para alinhar os elementos */
            flex-direction: column; /* Direção vertical */
            justify-content: center; /* Centraliza verticalmente */
            align-items: center; /* Centraliza horizontalmente */
            height: 100vh; /* Altura total da tela */
        }

        /* Estilo do formulário */
        form {
            background-color: #fae5ad; /* Cor de fundo do formulário */
            padding: 20px; /* Padding interno */
            border-radius: 5px; /* Bordas arredondadas */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra do formulário */
            width: 350px; /* Largura do formulário */
            text-align: center; /* Centraliza o texto no formulário */
        }

        /* Estilo dos títulos */
        h2 {
            color: #42392a; /* Cor do texto dos títulos */
            margin-bottom: 20px; /* Margem inferior para espaçamento */
        }

        /* Contêiner para os inputs */
        .input-container {
            display: flex; /* Usar flexbox para alinhar inputs */
            flex-direction: column; /* Direção vertical */
            width: 100%; /* Largura total */
            align-items: center; /* Alinhar os itens ao centro */
        }

        /* Estilos para os inputs e select */
        .input-funcao, .input-email, .input-senha, .input-nome {
            width: 80%; /* Largura dos campos */
            padding: 10px; /* Padding interno */
            margin-bottom: 10px; /* Margem inferior */
            border: none; /* Sem borda */
            border-radius: 5px; /* Bordas arredondadas */
            font-size: 16px; /* Tamanho da fonte */
            color: #42392a; /* Cor do texto */
        }

        /* Estilos para o botão */
        button {
            background-color: #887b66; /* Cor do botão */
            color: #42392a; /* Cor do texto do botão */
            padding: 10px; /* Tamanho do botão */
            border: none; /* Sem borda */
            border-radius: 5px; /* Bordas arredondadas */
            cursor: pointer; /* Muda o cursor ao passar sobre o botão */
            font-size: 16px; /* Tamanho da fonte */
            transition: background-color 0.3s; /* Transição suave */
            width: 100%; /* Largura total */
        }

        button:hover {
            background-color: #42392a; /* Cor do botão ao passar o mouse */
            color: #fae5ad; /* Mantém a cor do texto */
        }

        .register-actions {
            display: flex;
            flex-direction: column; /* Direção vertical */
            align-items: center; /* Alinha os itens ao centro */
            margin-top: 10px; /* Espaçamento acima */
        }

        .register-actions span {
            margin-top: 10px; /* Espaçamento acima do texto */
            color: #42392a; /* Cor do texto */
        }

        /* Mensagem de erro */
        p {
            color: red; /* Cor vermelha para mensagens de erro */
            margin: 0 0 10px 0; /* Margem apenas embaixo */
        }
    </style>
</head>
<body>
    <form method="POST" action="actions/cadastrar_usuario.php">
        <h2>Cadastro</h2>
        <?php
        session_start();
        if (isset($_SESSION['erro'])) {
            echo "<p>{$_SESSION['erro']}</p>";
            unset($_SESSION['erro']); // Remove a mensagem de erro após exibi-la
        }
        ?>

        <div class="input-container">
            <label for="funcao">Função:</label>
            <select name="funcao" id="funcao" class="input-funcao" required>
                <option value="Gerente">Gerente</option>
                <option value="Chef">Chef</option>
            </select>

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="input-nome" placeholder="Nome" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="input-email" placeholder="Email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" class="input-senha" placeholder="Senha" required>
        </div>

        <!-- Botão de cadastro e link para login -->
        <div class="register-actions">
            <button type="submit">Cadastrar</button>
            <span>Já tem uma conta? <a href="login.php">Faça login</a>.</span>
        </div>
    </form>
</body>
</html>
