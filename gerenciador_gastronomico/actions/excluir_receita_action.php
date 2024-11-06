<?php
session_start();
require '../config/conexao.php'; // Inclua o caminho correto para o arquivo de conexão

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Use `$pdo` se for assim que a variável é definida no arquivo de conexão
        $query = $pdo->prepare("DELETE FROM receitas WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        if ($query->execute()) {
            $_SESSION['mensagem'] = "Receita excluída com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao excluir a receita.";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

    header("Location: ../listar_receitas.php"); // Redireciona para a página de listagem
    exit();
} else {
    $_SESSION['erro'] = "ID de receita inválido.";
    header("Location: ../listar_receitas.php");
    exit();
}
