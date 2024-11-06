<?php
session_start();
require '../config/conexao.php'; // Inclua a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $custo_estimado = $_POST['custo_estimado'];

    try {
        // Insere a nova receita no banco de dados
        $query = $pdo->prepare("INSERT INTO receitas (nome, descricao, custo_estimado) VALUES (:nome, :descricao, :custo_estimado)");
        $query->bindParam(':nome', $nome);
        $query->bindParam(':descricao', $descricao);
        $query->bindParam(':custo_estimado', $custo_estimado);

        if ($query->execute()) {
            $_SESSION['mensagem'] = "Receita cadastrada com sucesso!";
            header("Location: ../listar_receitas.php"); // Redireciona para a página de listagem de receitas
            exit();
        } else {
            $_SESSION['erro'] = "Erro ao cadastrar a receita.";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    header("Location: ../cadastrar_receita.php"); // Redireciona para a página de cadastro em caso de erro
    exit();
}
?>
