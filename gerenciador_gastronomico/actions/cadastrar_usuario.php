<?php
session_start();
require '../config/conexao.php'; // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $tipo = $_POST['funcao'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o e-mail já está cadastrado
    $query = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $query->bindParam(':email', $email);
    $query->execute();

    if ($query->rowCount() > 0) {
        $_SESSION['erro'] = "E-mail já cadastrado!";
        header("Location: ../cadastro.php");
        exit();
    }

    // Insere o novo usuário no banco de dados
    $query = $pdo->prepare("INSERT INTO usuarios (nome, tipo, email, senha) VALUES (:nome, :tipo, :email, :senha)");
    $query->bindParam(':nome', $nome);
    $query->bindParam(':tipo', $tipo);
    $query->bindParam(':email', $email);
    $query->bindParam(':senha', $senha);

    if ($query->execute()) {
        // Cria a sessão para o novo usuário
        $_SESSION['usuario'] = $nome;
        $_SESSION['tipo_usuario'] = $tipo;

        // Redireciona para a página principal
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['erro'] = "Erro ao cadastrar. Tente novamente!";
        header("Location: ../cadastro.php");
        exit();
    }
}
?>
