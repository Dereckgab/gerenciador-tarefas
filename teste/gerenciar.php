<?php
session_start();

if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [];
}

// Exemplo simples para mudar status da tarefa (via GET)
if (isset($_GET['index']) && isset($_GET['acao'])) {
    $index = intval($_GET['index']);
    $acao = $_GET['acao'];

    if (isset($_SESSION['tarefas'][$index])) {
        if ($acao == 'concluir') {
            $_SESSION['tarefas'][$index]['status'] = 'Concluída';
        } elseif ($acao == 'pendente') {
            $_SESSION['tarefas'][$index]['status'] = 'Pendente';
        }
    }

    header("Location: gerenciar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Gerenciar Tarefas</title>
    <style>
        /* CSS Navbar e container */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;}
        .navbar {background-color: #007BFF; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;}
        .navbar h1 {margin: 0; font-size: 24px;}
        .navbar-links {display: flex; gap: 20px;}
        .navbar-links a {color: white; text-decoration: none; font-weight: bold;}
        .navbar-links a:hover {text-decoration: underline;}
        .container {padding: 30px;}
        h2 {color: #333;}
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 700px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-concluir { background-color: #28a745; }
        .btn-pendente { background-color: #ffc107; color: black; }
        .status-concluida { color: green; font-weight: bold; }
        .status-pendente { color: orange; font-weight: bold; }
    </style>
</head>
<body>

<div class="navbar">
    <h1>Gerenciamento de Tarefas</h1>
    <div class="navbar-links">
            <a href="./index.php">Cadastro de Usuário</a>
            <a href="./cadastro.php">Cadastro de Tarefa</a>
            <a href="./gerenciar.php">Gerenciar Tarefas</a>
        </div>
</div>

<div class="container">
    <h2>Gerenciar Tarefas</h2>

    <?php if (count($_SESSION['tarefas']) === 0): ?>
        <p>Nenhuma tarefa cadastrada.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['tarefas'] as $i => $tarefa): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($tarefa['titulo']) ?></td>
                        <td><?= nl2br(htmlspecialchars($tarefa['descricao'])) ?></td>
                        <td class="<?= $tarefa['status'] == 'Concluída' ? 'status-concluida' : 'status-pendente' ?>">
                            <?= $tarefa['status'] ?>
                        </td>
                        <td>
                            <?php if ($tarefa['status'] == 'Pendente'): ?>
                                <a href="?index=<?= $i ?>&acao=concluir" class="btn btn-concluir">Concluir</a>
                            <?php else: ?>
                                <a href="?index=<?= $i ?>&acao=pendente" class="btn btn-pendente">Reabrir</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
