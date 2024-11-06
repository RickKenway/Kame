<?php
session_start();
require 'config/conexao.php'; // Inclua o caminho correto para a sua conexão com o banco de dados

// Verifica se o ID da receita foi passado via GET
if (!isset($_GET['id'])) {
    echo "ID da receita não fornecido.";
    exit();
}

$id = $_GET['id'];

// Busca os dados da receita específica no banco de dados
try {
    $stmt = $pdo->prepare("SELECT * FROM receitas WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $receita = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$receita) {
        echo "Receita não encontrada.";
        exit();
    }
} catch (PDOException $e) {
    echo "Erro ao buscar receita: " . $e->getMessage();
    exit();
}

// Atualiza os dados da receita no banco de dados ao enviar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $custo_estimado = $_POST['custo_estimado'];

    try {
        $stmt = $pdo->prepare("UPDATE receitas SET nome = :nome, descricao = :descricao, custo_estimado = :custo_estimado WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':custo_estimado', $custo_estimado);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: listar_receitas.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar receita: " . $e->getMessage();
    }
}

// Adiciona ingredientes à receita e reduz a quantidade no estoque
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_ingredients'])) {
    $ingredientes_ids = $_POST['ingrediente_id'];
    $quantidades = $_POST['quantidade'];

    try {
        $pdo->beginTransaction(); // Inicia uma transação para garantir que todas as atualizações sejam aplicadas de forma atômica

        $stmt = $pdo->prepare("INSERT INTO receita_ingredientes (receita_id, ingrediente_id, quantidade) VALUES (:receita_id, :ingrediente_id, :quantidade)");
        $updateStockStmt = $pdo->prepare("UPDATE ingredientes SET quantidade_disponivel = quantidade_disponivel - :quantidade WHERE id = :ingrediente_id");

        foreach ($ingredientes_ids as $index => $ingrediente_id) {
            $quantidade = $quantidades[$index];
            
            // Insere o ingrediente na receita
            $stmt->bindParam(':receita_id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':ingrediente_id', $ingrediente_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantidade', $quantidade);
            $stmt->execute();

            // Atualiza o estoque do ingrediente
            $updateStockStmt->bindParam(':quantidade', $quantidade);
            $updateStockStmt->bindParam(':ingrediente_id', $ingrediente_id, PDO::PARAM_INT);
            $updateStockStmt->execute();
        }
        
        $pdo->commit(); // Confirma todas as operações
        header("Location: listar_receitas.php");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack(); // Reverte todas as alterações em caso de erro
        echo "Erro ao adicionar ingredientes e atualizar estoque: " . $e->getMessage();
    }
}

// Consulta para buscar todos os ingredientes disponíveis
try {
    $ingredientes_stmt = $pdo->query("SELECT * FROM ingredientes");
    $ingredientes = $ingredientes_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar ingredientes: " . $e->getMessage();
    $ingredientes = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Receita</title>
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

        .editar-container {
            background-color: #fae5ad;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin-top: 60px;
            color: #42392a;
        }

        .editar-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input[type="text"], input[type="number"], textarea, select {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
            color: #42392a;
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
            display: inline-block;
            text-align: center;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #42392a;
            color: #fae5ad;
        }

        .btn-cancel {
            background-color: #d9534f;
            margin-left: 10px;
        }

        .btn-cancel:hover {
            background-color: #a94442;
        }

        .form-section {
            margin-top: 30px;
        }
    </style>
    <script>
        function addIngredientField() {
            const container = document.getElementById("ingredients-container");
            const newField = document.createElement("div");
            newField.innerHTML = `
                <label>Ingrediente:</label>
                <select name="ingrediente_id[]" required>
                    <option value="" disabled selected>Selecione um ingrediente</option>
                    <?php foreach ($ingredientes as $ingrediente): ?>
                        <option value="<?php echo $ingrediente['id']; ?>"><?php echo htmlspecialchars($ingrediente['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Quantidade:</label>
                <input type="number" name="quantidade[]" step="0.01" required>
                <br>
            `;
            container.appendChild(newField);
        }
    </script>
</head>
<body>
    <div class="editar-container">
        <h1>Editar Receita</h1>
        <form action="" method="POST">
            <label for="nome">Nome da Receita:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($receita['nome']); ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($receita['descricao']); ?></textarea>

            <label for="custo_estimado">Custo Estimado:</label>
            <input type="number" id="custo_estimado" name="custo_estimado" step="0.01" value="<?php echo htmlspecialchars($receita['custo_estimado']); ?>" required>

            <button type="submit" name="update" class="btn">Salvar Alterações</button>
            <a href="listar_receitas.php" class="btn btn-cancel">Cancelar</a>
        </form>

        <div class="form-section">
            <h2>Adicionar Ingredientes</h2>
            <form action="" method="POST">
                <div id="ingredients-container">
                    <label>Ingrediente:</label>
                    <select name="ingrediente_id[]" required>
                        <option value="" disabled selected>Selecione um ingrediente</option>
                        <?php foreach ($ingredientes as $ingrediente): ?>
                            <option value="<?php echo $ingrediente['id']; ?>"><?php echo htmlspecialchars($ingrediente['nome']); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label>Quantidade:</label>
                    <input type="number" name="quantidade[]" step="0.01" required>
                </div>

                <button type="button" onclick="addIngredientField()" class="btn">Adicionar Mais Ingredientes</button>
                <button type="submit" name="add_ingredients" class="btn">Salvar Ingredientes</button>
            </form>
        </div>
    </div>
</body>
</html>
