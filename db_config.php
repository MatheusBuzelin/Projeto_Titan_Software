<?php
// Configuração do banco de dados
$host = 'localhost'; // Endereço do servidor MySQL
$db = 'controle_funcionarios'; // Nome do banco de dados
$user = 'root'; // Usuário do banco de dados
$pass = ''; // Senha do banco de dados (deixe em branco se estiver usando a configuração padrão do XAMPP)

$conn = new mysqli($host, $user, $pass, $db);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
?>
