<?php
session_start();
require '../config/conexao.php'; // Verifique se este caminho está correto e se a variável é `$pdo`

// Verifique se os dados do formulário estão definidos
if (isset($_POST['nome']) && isset($_POST['quantidade']) && isset($_POST['unidade'])) {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $unidade = $_POST['unidade'];

    try {
        // Supondo que a variável de conexão seja `$pdo`
        $stmt = $pdo->prepare("INSERT INTO ingredientes (nome, quantidade_disponivel, unidade) VALUES (:nome, :quantidade, :unidade)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':unidade', $unidade);

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = "Ingrediente cadastrado com sucesso!";
            header("Location: ../listar_estoque.php");
            exit();
        } else {
            $_SESSION['erro'] = "Erro ao cadastrar ingrediente.";
            header("Location: ../cadastro_ingrediente.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    $_SESSION['erro'] = "Dados do formulário incompletos.";
    header("Location: ../cadastro_ingrediente.php");
    exit();
}
?>
