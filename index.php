<?php
    try{
        $pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost", "root", "");
        
    }catch(PDOException $e){
        echo "Erro de conexão".$e->getMessage();
    }

    if(isset($_POST['nome']) && empty($_POST['nome']) == false){
        $nome = $_POST['nome'];
        $msg = $_POST['mensagem'];

        $sql = $pdo->prepare("INSERT INTO mensagens SET nome = :nome, msg = :msg, data_msg = NOW()");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":msg", $msg);
        $sql->execute();
        
        header("Location: index.php");
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de comentários</title>
</head>
<body>
    <fieldset>
        <form action="" method="post">
            Nome: <br>
            <input type="text" name="nome" id=""><br><br>
            Mensagem:<br>
            <textarea name="mensagem" id="" cols="30" rows="10"></textarea><br><br>
            <input type="submit" value="Enviar mensagem">
        </form>
    </fieldset>
    <br><br>

    <?php
        $sql = "SELECT * FROM `mensagens` ORDER BY data_msg DESC ";
        $sql = $pdo->query($sql);

        if($sql->rowCount() > 0){
            foreach($sql->fetchAll() as $msg){
                ?>
                    <strong><?php echo $msg['nome']; ?></strong><br>
                    <?php echo $msg['msg']; ?>
                    <hr>
                <?php
            }
        }
        else{
            echo "Não há mensagens!";
        }
    ?>
</body>
</html>