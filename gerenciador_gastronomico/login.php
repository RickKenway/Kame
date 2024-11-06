<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php"); // Redireciona para a página principal se o usuário já estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Estilo do formulário */
        form {
            background-color: #fae5ad;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        /* Estilo dos títulos */
        h2 {
            color: #42392a;
            margin-bottom: 20px;
        }

        /* Contêiner para os inputs */
        .input-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            align-items: center;
        }

        /* Estilos para os inputs e select */
        .input-funcao, .input-email, .input-senha {
            width: 80%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: #42392a;
        }

        /* Estilos para o botão */
        button {
            background-color: #887b66;
            color: #42392a;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #42392a;
            color: #fae5ad;
        }

        .login-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 10px;
        }

        .login-actions span {
            margin-top: 10px;
            color: #42392a;
        }

        /* Mensagem de erro */
        p {
            color: red;
            margin: 0 0 10px 0;
        }
    </style>
</head>
<body>
    <form method="POST" action="actions/login_action.php">
        <h2>Login</h2>
        
        <?php
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

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="input-email" placeholder="Email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" class="input-senha" placeholder="Senha" required>
        </div>

        <div class="login-actions">
            <button type="submit">Entrar</button>
            <span>Não possui conta? <a href="cadastro.php">Faça seu cadastro</a>.</span>
        </div>
    </form>
</body>
</html>
