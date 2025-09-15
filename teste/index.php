<?php
// Conexão com o banco de dados
$servername = "localhost";  // ou o seu servidor (ex: "127.0.0.1")
$username = "root";         // usuário padrão do MySQL
$password = "";             // senha padrão do MySQL (em branco se não tiver senha)
$dbname = "sistema_tarefas";  // nome do banco de dados

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Processamento do formulário
$mensagem = "";
$nome = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST['nome']);
    $email = htmlspecialchars($_POST['email']);

    // Inserir os dados no banco
    $sql = "INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "<h3>Usuário cadastrado com sucesso!</h3>
                     <p><strong>Nome:</strong> $nome</p>
                     <p><strong>Email:</strong> $email</p>";
    } else {
        $mensagem = "Erro ao cadastrar o usuário: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>  

    <!-- Navbar -->
    <div class="navbar">
        <h1>Gerenciamento de Tarefas</h1>
        <div class="navbar-links">
            <a href="./index.php">Cadastro de Usuário</a>
            <a href="./cadastro.php">Cadastro de Tarefa</a>
            <a href="./gerenciar.php">Gerenciar Tarefas</a>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="container">
        <h2>Cadastro de Usuário</h2>

        <form method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <input type="submit" value="Cadastrar">
        </form>

        <?php if (!empty($mensagem)) : ?>
            <div class="resultado">
                <?= $mensagem ?>
            </div>
        <?php endif; ?>
    </div>

    <?php
    // Fechar a conexão
    $conn->close();
    ?>

</body>
</html>
