<?php
session_start();
include 'db_config.php'; // Verifique se o caminho do arquivo de configuração do banco de dados está correto

// Verificando se o usuário está logado, caso contrário, redireciona para a página de login
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Processamento do formulário de cadastro de empresa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_empresa = $_POST['nome'];

    // Verifica se o nome da empresa foi preenchido
    if ($nome_empresa) {
        // Prepara a query para inserir a empresa
        $sql = "INSERT INTO tbl_empresa (nome) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nome_empresa);

        // Executa a query e verifica se foi bem-sucedido
        if ($stmt->execute()) {
            echo "Empresa cadastrada com sucesso!";
        } else {
            echo "Erro ao cadastrar a empresa: " . $stmt->error;
        }
    } else {
        echo "O nome da empresa é obrigatório!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Nova Empresa</title>
</head>
<body>

<h2>Cadastrar Nova Empresa</h2>

<!-- Formulário de cadastro de empresa -->
<form method="POST" action="cadastrar_empresa.php">
    <label for="nome">Nome da Empresa:</label>
    <input type="text" id="nome" name="nome" required>
    <br><br>
    <button type="submit">Cadastrar Empresa</button>
</form>

<br><br>
<a href="index.php">Voltar para a página inicial</
