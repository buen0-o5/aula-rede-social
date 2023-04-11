<?php
include("header.php");


$id = $_GET["from"];

$tudo = mysql_query("SELECT * FROM users WHERE id='$id'");
$saber = mysql_fetch_assoc($tudo);

$email = $saber["email"];

$sql = mysql_query("SELECT * FROM mensagens WHERE para='$login_cookie' AND de='$email' OR de='$login_cookie' AND para='$email' ORDER BY id");

if (isset($_POST["send"])) {
    $msg = $_POST['text'];
    $data = date("Y/m/d");

    if ($msg=="") {
        echo "<h3>Não pode enviar uma mensagem em branco!...</h3>";
    }else {
        $query = "INSERT INTO mensagens (`de`,`para`,`texto`, `status`,`data`) VALUES ('$login_cookie','$email','".mysql_real_escape_string($msg)."',0, '$data')";
        $data = mysql_query($query);
        if ($data) {
            header("refresh:0;");
        }else {
            echo "<h3 >Algo não ocorreu bem ao enviar sua mensagem...Desculpa</h3>".mysql_error();
        }
    }
}
?>


<html lang="pt-br">
<head>
<link rel="stylesheet" href="estilo/style-chat.css">
<style>
h3{
    text-align: center;
    font-size: 25px;
    color: #666;
}
</style>
</head>
<body>
    <br>
    <h2><a href="profile.php?id=<?php echo $id;?>"><?php echo $saber["nome"];?></a></h2><br><br><br>
    <form method="POST">
    <div id="box">
    <object type="text/html" data="bubble.php?from=<?php echo $id; ?>#bottom" width="635px" height="390px" style="overflow:auto;"></object>
    </div>
    <br>
    <div id="send">
    <a href="image.php?id=<?php echo $id;?>"><input value="Imagem" type="button" name="image"></a>&nbsp;&nbsp;&nbsp;<input type="text" name="text" placeholder="Escreva aqui uma mensagem..." autocomplete="off"><input type="submit" name="send" value="Enviar">

    </div>
    </form>
</body>
</html>