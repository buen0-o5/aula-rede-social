<?php
include("header.php");
$sql = mysql_query("SELECT * FROM mensagens WHERE para='$login_cookie' GROUP BY de ORDER BY id");

$ups = mysql_query("SELECT * FROM mensagens WHERE para='$login_cookie' AND status=0");
$contagem = mysql_num_rows($ups);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
<link rel="stylesheet" href="estilo/style-inbox.css">
</head>

<body>
    <h2>Conversas</h2>
    <!--<img id="papo" src="img/testbate1.jpg" alt="ico">-->
    <form method="POST">
        <div>
            <?php

     while ($msg = mysql_fetch_assoc($sql)) {
        $from = $msg["de"];
        $tudo = mysql_query("SELECT * FROM users WHERE email='$from'");
        $img = mysql_fetch_assoc($tudo);
        $conta = mysql_query("SELECT * FROM mensagens WHERE de='$from' AND para='$login_cookie' AND status=0 ");
        $contar = mysql_num_rows($conta);

        echo '<br/> <a name="d" href="chat.php?from=' . $img["id"] . '"><div id="box" >
        <br/><p>' . $img["nome"] . ' ' . $img["apelido"] . ' - ' . $contar . ' mensagens novas</p><br/>
        </div><a/><br/>
            <hr/>';
           }
        

?>

        </div>
    </form>
    <br/><br/>
    <div id="rodape">
        <p>&copy; Meet new Friends, 2022 - Todos os direitos reservados </p>
    </div><br>
</body>
</html>