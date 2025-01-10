<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}

include 'db_config.php';

$sql = "SELECT f.*, e.nome AS empresa_nome 
        FROM tbl_funcionario f
        LEFT JOIN tbl_empresa e ON f.id_empresa = e.id_empresa";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Funcionários</title>
    <style>
        .blue { background-color: blue; color: white; }
        .red { background-color: red; color: white; }
    </style>
</head>
<body>
    <h1>Funcionários</h1>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>RG</th>
            <th>Email</th>
            <th>Empresa</th>
            <th>Data de Cadastro</th>
            <th>Salário</th>
            <th>Bonificação</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): 
            $data_cadastro = new DateTime($row['data_cadastro']);
            $hoje = new DateTime();
            $intervalo = $hoje->diff($data_cadastro);
            $anos = $intervalo->y;
            $classe = '';

            if ($anos > 5) {
                $classe = 'red';
            } elseif ($anos > 1) {
                $classe = 'blue';
            }
        ?>
        <tr class="<?php echo $classe; ?>">
            <td><?php echo $row['nome']; ?></td>
            <td><?php echo $row['cpf']; ?></td>
            <td><?php echo $row['rg']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['empresa_nome']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($row['data_cadastro'])); ?></td>
            <td>R$ <?php echo number_format($row['salario'], 2, ',', '.'); ?></td>
            <td>R$ <?php echo number_format($row['bonificacao'], 2, ',', '.'); ?></td>
            <td>
                <a href="editar_funcionario.php?id=<?php echo $row['id_funcionario']; ?>">Editar</a>
                <a href="excluir_funcionario.php?id=<?php echo $row['id_funcionario']; ?>">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="cadastrar_empresa.php">Cadastrar Empresa</a>
    <a href="cadastrar_funcionario.php">Cadastrar Funcionário</a>
</body>
</html>
