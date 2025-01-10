<?php
session_start();
include 'db_config.php'; // Verifique se o caminho do arquivo de configuração do banco de dados está correto

// Verificando se o usuário está logado, caso contrário, redireciona para a página de login
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Processamento do formulário de cadastro de funcionário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $email = $_POST['email'];
    $id_empresa = $_POST['id_empresa'];

    // Verifica se todos os campos obrigatórios foram preenchidos
    if ($nome && $cpf && $rg && $email && $id_empresa) {
        // Prepara a query para inserir o funcionário
        $sql = "INSERT INTO tbl_funcionario (nome, cpf, rg, email, id_empresa, data_cadastro, salario, bonificacao) 
                VALUES (?, ?, ?, ?, ?, NOW(), 0, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nome, $cpf, $rg, $email, $id_empresa);

        // Executa a query e verifica se foi bem-sucedido
        if ($stmt->execute()) {
            echo "Funcionário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o funcionário: " . $stmt->error;
        }
    } else {
        echo "Todos os campos são obrigatórios!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
</head>
<body>

<h2>Cadastrar Novo Funcionário</h2>

<!-- Formulário de cadastro de funcionário -->
<form method="POST" action="cadastrar_funcionario.php">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>
    <br><br>
    <label for="cpf">CPF:</label>
    <input type="text" id="cpf" name="cpf" required>
    <br><br>
    <label for="rg">RG:</label>
    <input type="text" id="rg" name="rg" required>
    <br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br><br>
    <label for="id_empresa">Empresa:</label>
    <select name="id_empresa" id="id_empresa" required>
        <?php
        // Buscar as empresas cadastradas no banco
        $sql = "SELECT * FROM tbl_empresa";
        $result = $conn->query($sql);

        // Exibe as empresas no menu select
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_empresa'] . "'>" . $row['nome'] . "</option>";
        }
        ?>
    </select>
    <br><br>
    <button type="submit">Cadastrar Funcionário</button>
</form>

<br><br>
<a href="index.php">Voltar para a página inicial</a>

</body>
</html>
