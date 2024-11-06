<?php
session_start();
require 'config/conexao.php'; // Inclua o caminho correto para o arquivo de conexão

// Consulta para obter todos os ingredientes do estoque
try {
    $stmt = $pdo->query("SELECT * FROM ingredientes");
    $ingredientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar ingredientes: " . $e->getMessage();
    $ingredientes = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Estoque de Ingredientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
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
            box-sizing: border-box;
        }
        header {
            background-color: #fae5ad;
            color: #42392a;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 800px;
        }
        .ingredientes-container {
            background-color: #fae5ad;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
        }
        .btn {
            background-color: #887b66;
            color: #42392a;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin: 10px 0;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #42392a;
            color: #fae5ad;
        }
        .ingrediente-card {
            background-color: #ffffff;
            color: #42392a;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        .ingrediente-card h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .ingrediente-card p {
            margin: 5px 0;
            font-size: 16px;
            color: #6a4f31;
        }
        .btn-excluir {
            color: #dc3545;
            border: 1px solid #dc3545;
            background-color: transparent;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px;
        }
        .btn-excluir:hover {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>
    <header>
        <h2>Ingredientes no Estoque</h2>
    </header>

    <div class="ingredientes-container">
        <a href="cadastro_ingrediente.php" class="btn">
            <i class="fas fa-plus"></i> Cadastrar Novo Ingrediente
        </a>

        <?php if (!empty($ingredientes)): ?>
            <?php foreach ($ingredientes as $ingrediente): ?>
                <div class="ingrediente-card" id="ingrediente-<?php echo $ingrediente['id']; ?>">
                    <h3><?php echo htmlspecialchars($ingrediente['nome']); ?></h3>
                    <p>Quantidade: <?php echo htmlspecialchars($ingrediente['quantidade_disponivel']); ?> <?php echo htmlspecialchars($ingrediente['unidade']); ?></p>
                    <button class="btn-excluir" onclick="excluirIngrediente(<?php echo $ingrediente['id']; ?>)">
                        <i class="fas fa-trash"></i> Excluir
                    </button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum ingrediente cadastrado no estoque.</p>
        <?php endif; ?>

        <a href="index.php" class="btn">
            <i class="fas fa-arrow-left"></i> Voltar ao Painel
        </a>
    </div>

    <script>
        function excluirIngrediente(id) {
            if (confirm("Tem certeza que deseja excluir este ingrediente?")) {
                fetch(`actions/excluir_ingrediente_action.php?id=${id}`, { method: 'GET' })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Erro ao acessar o script de exclusão.");
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            document.getElementById(`ingrediente-${id}`).remove();
                        } else {
                            alert("Erro ao excluir ingrediente: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Erro na solicitação AJAX:", error);
                        alert("Erro ao excluir ingrediente.");
                    });
            }
        }
    </script>
</body>
</html>
