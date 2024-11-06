<?php
session_start();
require 'config/conexao.php'; // Inclua o caminho correto para o arquivo de conexão

try {
    // Obtem todas as receitas
    $stmt = $pdo->query("SELECT * FROM receitas");
    $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Inicializa array para associar ingredientes a receitas
    $receitasComIngredientes = [];

    foreach ($receitas as $receita) {
        // Obtem os ingredientes para cada receita
        $stmt_ingredientes = $pdo->prepare("
            SELECT i.nome AS ingrediente_nome, ri.quantidade, i.unidade 
            FROM receita_ingredientes ri
            JOIN ingredientes i ON ri.ingrediente_id = i.id
            WHERE ri.receita_id = :receita_id
        ");
        $stmt_ingredientes->bindParam(':receita_id', $receita['id'], PDO::PARAM_INT);
        $stmt_ingredientes->execute();
        $ingredientes = $stmt_ingredientes->fetchAll(PDO::FETCH_ASSOC);

        // Adiciona ingredientes à receita específica
        $receita['ingredientes'] = $ingredientes;
        $receitasComIngredientes[] = $receita;
    }
} catch (PDOException $e) {
    echo "Erro ao buscar receitas: " . $e->getMessage();
    $receitasComIngredientes = []; 
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar Receitas</title>
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

        .receitas-container {
            background-color: #fae5ad;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin: 60px auto;
            overflow-y: auto;
            max-height: 60vh;
            box-sizing: border-box;
        }

        .receitas-container h1 {
            color: #42392a;
            text-align: center;
            margin: 0 0 20px 0;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            background-color: #ffffff;
            color: #000000;
        }

        th {
            background-color: #e6e1c3;
            color: #42392a;
        }

        .btn {
            background-color: #887b66;
            color: #42392a;
            padding: 10px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin: 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        .btn i {
            margin-right: 5px;
        }

        .btn:hover {
            background-color: #42392a;
            color: #fae5ad;
        }

        .ingredientes-list {
            margin-top: 10px;
            color: #42392a;
            font-size: 14px;
        }

        footer {
            background-color: #fae5ad;
            color: #42392a;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="receitas-container">
        <h1>Listar Receitas</h1>

        <p>
            <a href="cadastro_receita.php" class="btn">
                <i class="fas fa-plus"></i> Cadastrar Nova Receita
            </a>
        </p>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Custo Estimado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($receitasComIngredientes)) : ?>
                    <?php foreach ($receitasComIngredientes as $receita) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($receita['nome']); ?></td>
                            <td><?php echo htmlspecialchars($receita['descricao']); ?></td>
                            <td><?php echo htmlspecialchars($receita['custo_estimado']); ?></td>
                            <td>
                                <a href="editar_receita.php?id=<?php echo $receita['id']; ?>" class="btn">
                                    <i class="fas fa-plus-circle"></i> Adicionar Ingrediente
                                </a>
                                <a href="actions/excluir_receita_action.php?id=<?php echo $receita['id']; ?>" class="btn" onclick="return confirm('Tem certeza que deseja excluir esta receita?');">
                                    <i class="fas fa-trash"></i> Excluir
                                </a>
                            </td>
                        </tr>
                        <?php if (!empty($receita['ingredientes'])): ?>
                            <tr>
                                <td colspan="4">
                                    <div class="ingredientes-list">
                                        <strong>Ingredientes:</strong>
                                        <ul>
                                            <?php foreach ($receita['ingredientes'] as $ingrediente): ?>
                                                <li>
                                                    <?php echo htmlspecialchars($ingrediente['ingrediente_nome']); ?>: 
                                                    <?php echo htmlspecialchars($ingrediente['quantidade']); ?> 
                                                    <?php echo htmlspecialchars($ingrediente['unidade']); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Nenhuma receita encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <p>
            <a href="index.php" class="btn">
                <i class="fas fa-undo"></i> Voltar
            </a>
        </p>
    </div>

    <footer>
        <p>&copy; 2024 Sistema de Gerenciamento de Receitas</p>
    </footer>
</body>
</html>
