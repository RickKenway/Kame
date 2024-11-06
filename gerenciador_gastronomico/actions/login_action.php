<?php
session_start();
require '../config/conexao.php'; // Inclua a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $funcao = $_POST['funcao'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        // Consulta para buscar o usuário com o e-mail e função
        $query = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND tipo = :funcao");
        $query->bindParam(':email', $email);
        $query->bindParam(':funcao', $funcao);
        $query->execute();

        if ($query->rowCount() > 0) {
            $usuario = $query->fetch();

            // Verificar se a senha informada corresponde à senha armazenada
            if ($senha === $usuario['senha']) {
                $_SESSION['usuario'] = $usuario['nome'];
                $_SESSION['tipo_usuario'] = $usuario['tipo'];
                header("Location: ../index.php"); // Redireciona para a página principal
                exit();
            } else {
                $_SESSION['erro'] = "Credenciais inválidas!";
            }
        } else {
            $_SESSION['erro'] = "Credenciais inválidas!";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    header("Location: ../login.php"); // Redireciona para a página de login em caso de erro
    exit();
}
?>
