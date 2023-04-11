<?php
include("header.php");

$pubs = mysql_query("SELECT * FROM amizades WHERE para='$login_cookie' AND aceite='0' ORDER BY id desc");
$notificacoes = mysql_query("SELECT * FROM notificacoes WHERE userpara='$login_cookie' ORDER BY id desc");

if (isset($_GET['id'])) {
    $id = $_GET["id"];
    $saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
    $saber = mysql_fetch_assoc($saberr);
    $email = $saber['email'];

    $ins = "UPDATE  amizades SET `aceite`='1' WHERE`de`='$email' AND `para`='$login_cookie'";
    $conf = mysql_query($ins) or die (mysql_error());
    if($conf){
        header("Location: notificacoes.php");
    }else{
        echo "<h3>Erro ao aceitar amizade...</h3>";
    }
}

if (isset($_GET['remover'])) {
    $id = $_GET["remover"];
    $saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
    $saber = mysql_fetch_assoc($saberr);
    $email = $saber['email'];

    $ins = "DELETE FROM amizades WHERE `de`='$login_cookie' AND `para`='$email' OR `para`='$login_cookie' AND `de`='$email'";
    $conf = mysql_query($ins) or die (mysql_error());
    if($conf){
        header("Location: notificacoes.php");
    }else{
        echo "<h3>Erro ao desfazer amizade...</h3>";
    }
}



?>
<!DOCTYPE html>
<html>

<head>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="estilo/style-notificacoes.css">
    
</head>

<body>
    <br>
    <br>
    <br>

    <?php
    
    if (mysql_num_rows($pubs)>=1) {
        echo "<h3>Os seus pedidos de amizade:</h3>";
            while ($pub = mysql_fetch_assoc($pubs)) {
                $email = $pub['de'];
                $saberr = mysql_query("SELECT * FROM users WHERE email='$email' ");
                $saber = mysql_fetch_assoc($saberr);
                $nome = $saber['nome'] . " " . $saber['apelido'];
                $id = $pub['id'];
        
                
                    echo '<div class="pub" id="' . $id . '">
                    <span><h4>' . $nome .', lhe mandou uma solicitação de amizade</h5></span>
                    <p><a href="profile.php?id=' . $saber['id'] . '">Ver perfil de ' . $nome . '</a> </p><br>
                    <a href="notificacoes.php?id='.$saber['id'].'"> <input type="submit" value="Aceitar" id="add" name="add"></a>
                    <a href="notificacoes.php?remove="><input type="submit" value="Remover" id="remo" name="remover"></a>
                    </div>';
            }
            echo "<br/><h3>Você não possui pedidos de amizade...</h3><br/>";
    }
    ?>

<?php
    
    if (mysql_num_rows($notificacoes)>=1) {
        echo "<h3>As suas notificações:</h3>";
            while ($not = mysql_fetch_assoc($notificacoes)) {
                $email = $not['userde'];
                $saberr = mysql_query("SELECT * FROM users WHERE email='$email' ");
                $saber = mysql_fetch_assoc($saberr);
                $nome = $saber['nome'] . " " . $saber['apelido'];
                $id = $not['id'];
        
                
                  if ($not['tipo']=="1") {
                    echo '<div class="not" id="' . $id . '">
                    <a href="comentarios.php?id='.$not['post'].'">'.$nome.' curtiu sua publicação</a>
                    </div>';
                  }elseif($not['tipo']=="2") {
                    echo '<div class="not" id="' . $id . '">
                    <a href="comentarios.php?id='.$not['post'].'">'.$nome.' comentou sua publicação</a>
                    </div>';
                  }
            }
            echo "<br/><h3>Você não possui notificações...</h3>";
    }else {
        echo "<br/><h3>Você não possui notificações...</h3>";
    }
    ?>
    <br>
    <div id="rodape">
        <p>&copy; Meet new Friends, 2022 - Todos os direitos reservados </p>
    </div><br>

</body>

</html>