<?php 
try {
    $pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost", "root", "");
} catch(PDOException $e) {
    echo "Falhou: ".$e->getMessage();
    exit;
}

if(isset($_POST["nome"]) && !empty($_POST["nome"])) {
    $nome = addslashes($_POST["nome"]);
    $msg = addslashes($_POST["mensagem"]);

    $sql = $pdo->prepare("INSERT INTO comentarios (nome, msg, data_msg) VALUES(:nome, :msg, NOW())");
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":msg", $msg);
    $sql->execute();
    
}

?>
<fieldset>
    <form method="POST">
        Nome:<br>
        <input type="text" name="nome"><br><br>

        Mensagem:<br>
        <textarea name="mensagem"></textarea><br><br>

        <input type="submit" value="Enviar Mensagem">

    </form>
</fieldset>
<br><br>

<?php 
$sql = "SELECT * FROM comentarios ORDER BY data_msg DESC";
$sql = $pdo->query("$sql");

if($sql->rowCount() > 0) {
    foreach($sql->fetchAll() as $comentario):
        ?>
            <strong><?php echo $comentario["nome"]; ?></strong><br>
                <?php echo $comentario["msg"]; ?>
            <hr>
        <?php
    endforeach;
} else {
    echo "Não há mensagens!";
}

?>
