<?php
header('Content-Type: application/json');
require '../config/conexao.php';

$response = ['success' => false, 'message' => 'Erro ao excluir ingrediente.'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM ingredientes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = 'Ingrediente excluído com sucesso!';
        } else {
            $response['message'] = 'Ingrediente não encontrado ou já excluído.';
        }
    } catch (PDOException $e) {
        $response['message'] = 'Erro de banco de dados: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'ID do ingrediente não fornecido.';
}

echo json_encode($response);
?>
