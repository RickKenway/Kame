<?php
// conexao.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gerenciador_gastronomico";
?>

<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=gerenciador_gastronomico", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit();
}
?>
