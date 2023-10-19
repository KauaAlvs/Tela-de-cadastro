<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "magiamistica";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verificar se o email existe no banco de dados
    $verificar_email = "SELECT * FROM Usuarios WHERE email = '$email'";
    $resultado = $conn->query($verificar_email);

    if ($resultado->num_rows == 1) {
        $row = $resultado->fetch_assoc();
        if (password_verify($senha, $row["senha"])) {
            $_SESSION["usuario_id"] = $row["usuario_id"];

            //Esta linha para obter e armazenar o nível mágico do usuário
            $_SESSION["nivel_magico"] = $row["nivel_magico"];

            header("Location: products.php");
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MagiaMística - Login</title>
    <link rel="stylesheet" href="stylelogin.css">
</head>

<body>
    <main class="login-form">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem uma conta? <a href="register.php">Crie uma aqui</a>.</p>
    </main>

    <footer>
        &copy; 2023 MagiaMística
    </footer>
</body>

</html>