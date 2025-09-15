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

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao = htmlspecialchars(trim($_POST['descricao']));
    $setor = htmlspecialchars(trim($_POST['setor']));
    $usuario = htmlspecialchars(trim($_POST['usuario']));
    $prioridade = htmlspecialchars(trim($_POST['prioridade']));

    // Inserir os dados no banco de dados
    $sql = "INSERT INTO tarefas (descricao, setor, usuario, prioridade)
            VALUES ('$descricao', '$setor', '$usuario', '$prioridade')";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "<h3>Tarefa cadastrada com sucesso!</h3>
                     <p><strong>Descrição:</strong> $descricao</p>
                     <p><strong>Setor:</strong> $setor</p>
                     <p><strong>Usuário:</strong> $usuario</p>
                     <p><strong>Prioridade:</strong> $prioridade</p>";
    } else {
        $mensagem = "Erro ao cadastrar a tarefa: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Cadastro de Tarefa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        /* Navbar */
        .navbar {
            background-color: #007BFF; /* Azul */
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .navbar-links {
            display: flex;
            gap: 20px;
        }

        .navbar-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar-links a:hover {
            text-decoration: underline;
        }

        /* Conteúdo principal */
        .container {
            padding: 30px;
            max-width: 500px;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 100%;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #000000;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .resultado {
            margin-top: 20px;
            background-color: #42ac42;
            padding: 15px;
            border-radius: 8px;
        }
    </style>
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
        <h2>Cadastro de Tarefa</h2>

        <form method="POST" action="">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>

            <label for="setor">Setor:</label>
            <input type="text" id="setor" name="setor" required>

            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="prioridade">Prioridade:</label>
            <select id="prioridade" name="prioridade" required>
                <option value="" disabled selected>Selecione a prioridade</option>
                <option value="Baixa">Baixa</option>
                <option value="Média">Média</option>
                <option value="Alta">Alta</option>
            </select>

            <input type="submit" value="Cadastrar Tarefa">
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
