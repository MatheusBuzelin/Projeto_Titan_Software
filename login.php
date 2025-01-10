<?php
session_start();

// Incluindo o arquivo de configuração de banco de dados
include 'db_config.php'; // Certifique-se de que o caminho está correto

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login']);
$senha = trim($_POST['senha']); // Certifique-se de que a senha está recebendo o valor correto

// Depuração: exibe os valores para verificar
var_dump($login, $senha);

// Se a senha foi enviada corretamente, agora aplicamos o MD5:
$senha = md5($senha); // Transformamos a senha em MD5



    if ($login && $senha) {
        // Usando a variável $conn para a conexão com o banco
        $sql = "SELECT * FROM tbl_usuario WHERE login = ? AND senha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $login, $senha);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows > 0) {
            $_SESSION['usuario'] = $login;
            header("Location: dashboard.php");
        } else {
            echo "Login ou senha incorretos.";
        }
    } else {
        echo "Por favor, insira um email válido e senha.";
    }
}

?>


