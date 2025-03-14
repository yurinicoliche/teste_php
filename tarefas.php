<?php

    $con = new PDO("mysql:host=localhost;dbname=tarefas", "root", "1234");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['tarefa'])) {
        $tarefa = filter_input(INPUT_POST, 'tarefa', FILTER_SANITIZE_STRING);
        $query = "INSERT INTO tarefas (descricao, concluida) VALUES (:descricao, 0)";
        $smt = $con->prepare($query);
        $smt->bindParam('descricao', $tarefa);
        $smt->execute();
       

    }

    if (isset($_GET['excluir'])) {
        $id = filter_input(INPUT_GET, 'excluir', FILTER_SANITIZE_NUMBER_INT);
        $query = "DELETE FROM tarefas WHERE id=:id";
        $smt = $con->prepare($query);
        $smt->bindParam('id', $id);
        $smt->execute();

        header('Location: http://localhost/videos/tarefas.php');

    }

    if (isset($_GET['concluir'])) {
        $id = filter_input(INPUT_GET, 'concluir', FILTER_SANITIZE_NUMBER_INT);
        $query = "UPDATE tarefas SET concluida=1 WHERE id=:id";
        $stm = $con->prepare($query);
        $smt->bindParam('id', $id);
        $smt->execute();

        header('Location: http://localhost/videos/tarefas.php');

    }

    if (isset($_GET['reabrir'])) {
        $id = filter_input(INPUT_GET, 'reabrir', FILTER_SANITIZE_NUMBER_INT);
        $query = "UPDATE tarefas SET concluida=0 WHERE id=:id";
        $smt = $con->prepare($query);
        $smt->bindParam('id', $id);
        $smt->execute();

        header('Location http://loccalhost/videos/tarefas.php');
    }

    $query = "SELECT id, descricao,concluida FROM tarefas";
    $lista = $con->query($query)->fetchAll();
    
     


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        form {
            padding: 10px;
            border: 2px solid grey;
            border-radius: 20px;
            width: 300px;
        }

        div.list {
            margin-top: 10px;
            padding: 10px;
            border-radius: 20px;
            width: 300px;
        }
    </style>
</head>
<body>
    <form method="post">
        Nova tarefa: <input type="text" name="tarefa">
    </form>
    <div class="list">
        <ul>
            <?php foreach($lista as $item): ?>
                <li><?-$lista['descricao']?>
                    <?php if(!$item['concluida']): ?>
                        <a href="?concluir=<?=$item['id']?>">[Concluir]</a>
                        <?php else: ?>
                            <a href="?reabrir=<?=$item['id']?>">[Reabrir]</a>
                        <?php  endif; ?>
                        <a href="?excluir=<?=$item['id']?>">[Excluir]</a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>