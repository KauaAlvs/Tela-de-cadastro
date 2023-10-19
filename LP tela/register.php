<?php
//arquivo register.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $confirmar_senha = $_POST["confirmar_senha"];

    // Validar se as senhas coincidem
    if ($senha !== $confirmar_senha) {
        echo "As senhas não coincidem. Tente novamente.";
        exit();
    }

    // Conectar ao banco de dados (substitua as informações conforme necessário)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "magiamistica";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verificar se o email já está registrado
    $verificar_email = "SELECT * FROM Usuarios WHERE email = '$email'";
    $resultado = $conn->query($verificar_email);

    if ($resultado->num_rows > 0) {
        echo "Este email já está registrado. Por favor, use outro email.";
        $conn->close();
        exit();
    }

    // Criptografar a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir dados no banco de dados
    $inserir_usuario = "INSERT INTO Usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha_hash')";

    if ($conn->query($inserir_usuario) === TRUE) {
        echo "Usuário registrado com sucesso!";
    } else {
        echo "Erro ao registrar o usuário: " . $conn->error;
    }
    header("Location: login.php");
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MagiaMística - Registro de Usuário</title>
    <link rel="stylesheet" href="styleregister.css">
</head>

<body>
    <main class="register-form">
        <h2>Criar uma Conta</h2>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar_senha">Confirmar Senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            </div>
            <button type="submit">Registrar</button>
        </form>
        <p>Criou ou já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>
    </main>

    <footer>
        &copy; 2023 MagiaMística
    </footer>
</body>

</html>