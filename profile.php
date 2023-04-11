<?php
include("header.php");

$id = $_GET["id"];
$saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
$saber = mysql_fetch_assoc($saberr);
$email = $saber['email'];

if ($email==$login_cookie) {
    header("Location: myprofile.php");
    
}

$pubs = mysql_query("SELECT * FROM pubs WHERE user='$email' ORDER BY id desc");
 
if(isset($_POST['add'])){
    add();
}

function add(){
    $login_cookie = $_COOKIE['login'];
    if(!isset($login_cookie)){
        header("Location: login.php");
    }
    $id = $_GET["id"];
    $saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
    $saber = mysql_fetch_assoc($saberr);
    $email = $saber['email'];
    $data = date("Y/m/d");

    $ins = "INSERT INTO amizades (`de`,`para`,`data`) VALUES ('$login_cookie','$email','$data')";
    $conf = mysql_query($ins) or die (mysql_error());
    if($conf){
        header("Location: profile.php?id=".$id);
    }else{
        echo "<h3>Erro ao enviar pedido...</h3>";
    }
}


if(isset($_POST['cancelar'])){
    cancelar();
}

function cancelar(){
    $login_cookie = $_COOKIE['login'];
    if(!isset($login_cookie)){
        header("Location: login.php");
    }
    $id = $_GET["id"];
    $saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
    $saber = mysql_fetch_assoc($saberr);
    $email = $saber['email'];

    $ins = "DELETE FROM amizades WHERE `de`='$login_cookie' AND `para`='$email'";
    $conf = mysql_query($ins) or die (mysql_error());
    if($conf){
        header("Location: profile.php?id=".$id);
    }else{
        echo "<h3>Erro ao cancelar pedido...</h3>";
    }
}


if(isset($_POST['remover'])){
    remover();
}
if(isset($_POST['chat'])){
    header("Location:chat.php?from=" . $id);
}
function remover(){
    $login_cookie = $_COOKIE['login'];
    if(!isset($login_cookie)){
        header("Location: login.php");
    }
    $id = $_GET["id"];
    $saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
    $saber = mysql_fetch_assoc($saberr);
    $email = $saber['email'];

    $ins = "DELETE FROM amizades WHERE `de`='$login_cookie' AND `para`='$email' OR `para`='$login_cookie' AND `de`='$email'";
    $conf = mysql_query($ins) or die (mysql_error());
    if($conf){
        header("Location: profile.php?id=".$id);
    }else{
        echo "<h3>Erro ao desfazer amizade...</h3>";
    }
}


if(isset($_POST['aceitar'])){
    aceitar();
}

function aceitar(){
    $login_cookie = $_COOKIE['login'];
    if(!isset($login_cookie)){
        header("Location: login.php");
    }
    $id = $_GET["id"];
    $saberr = mysql_query("SELECT * FROM users WHERE id='$id'");
    $saber = mysql_fetch_assoc($saberr);
    $email = $saber['email'];

    $ins = "UPDATE  amizades SET `aceite`='1' WHERE`de`='$email' AND `para`='$login_cookie'";
    $conf = mysql_query($ins) or die (mysql_error());
    if($conf){
        header("Location: profile.php?id=".$id);
    }else{
        echo "<h3>Erro ao desfazer amizade...</h3>";
    }
}


?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="estilo/style-profile.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
   
  

</head>

<body>
    <?php
    if ($saber["img"] == "") {
        echo '<img src="img/user.png" id="profile">';
    } else {
        echo '<img src="upload/' . $saber["img"] . '" id="profile">';
    }


    ?>
    <div id="menu">
        <form method="POST">
        <h2><?php echo $saber['nome'] . " " . $saber['apelido']; ?></h2><br>
        <?php
        $amigos = mysql_query("SELECT * FROM amizades WHERE de='$login_cookie' AND para='$email' OR para='$login_cookie' AND de='$email' ");
        $amigoss = mysql_fetch_assoc($amigos);
        if (mysql_num_rows($amigos)>=1 AND $amigoss["aceite"]=="1") {
          echo  '<input type="submit" value="Remover Amigo" name="remover">
          &nbsp;&nbsp;
          <input type="submit" name="chat" value="Conversar" >
          <input type="submit" name="denunciar" value="Denunciar" >';
        } elseif (mysql_num_rows($amigos)>=1 AND $amigoss["aceite"]=="0" AND $amigoss["para"]=="$login_cookie") {
                echo  '<input type="submit" value="Aceitar Pedido" name="aceitar">
                &nbsp;&nbsp;
                <input type="submit" name="chat" value="Conversar" >
               <input type="submit" name="denunciar" value="Denunciar" >';
       
       }elseif (mysql_num_rows($amigos)>=1 AND $amigoss["aceite"]=="0" AND $amigoss
       ["de"]=="$login_cookie") {
        echo  '<input type="submit" value="Cancelar Pedido" name="cancelar">
        &nbsp;&nbsp;
        <input type="submit" name="chat" value="Conversar" >
        <input type="submit" name="denunciar" value="Denunciar" >';
        } else {
            echo  '<input type="submit" value="Adicioanar Amigo" name="add">
            <input type="submit" name="chat" value="Conversar" >
            <input type="submit" name="denunciar" value="Denunciar" >';
            
            

        }
    ?>

    </form>
    </div>
    <?php
     $saberr = mysql_query("SELECT * FROM users WHERE email='$email' ");
     $saber = mysql_fetch_assoc($saberr);
     $nome = $saber['nome'] . " " . $saber['apelido'];
    
    
    $amigoss = mysql_query("SELECT * FROM amizades WHERE de='$login_cookie' AND  
    para='$email' AND aceite='1' OR para='$login_cookie' AND  
    de='$email' AND aceite='1'");
    $amigos = mysql_num_rows($amigoss);
    if($amigos==1){
        while ($pub = mysql_fetch_assoc($pubs)) {
            $email = $pub['user'];
            $saberr = mysql_query("SELECT * FROM users WHERE email='$email' ");
            $saber = mysql_fetch_assoc($saberr);
            $nome = $saber['nome'] . " " . $saber['apelido'];
            $id = $pub['id'];

                    if ($pub['imagem'] == "") {
                        echo '<div class="pub" id="' . $id . '">
                             <p><a href="profile.php?id=' . $saber['id'] . '">' . $nome . '</a> -' . $pub["data"] . '</p>
                             <span>' . $pub['texto'] . '</span></br>
                        </div>';
                    } else {
                        echo '<div class="pub" id="' . $id . '">
                            <p><a href="profile.php?id=' . $saber['id'] . '">' . $nome . '</a>      -' . $pub["data"] . '</p>
                            <span>' . $pub['texto'] . '</span>
                            <img src="upload/' . $pub["imagem"] . '"/>
                        </div>';
                    }
       
                }
    
            }else if($amigos==0) {
             echo '<div class="pub" id="' . $id . '">
                <p><strong>Aviso sobre as amizades...</strong></p>
                <span>Tem que ser amigo(a) do(a) <strong>'.$nome.'</strong> para poder ver suas publicações...</span><br/>
            </div>';   
            }

    ?>
    <br>
    <div id="rodape">
        <p>&copy; Meet new Friends, 2022 - Todos os direitos reservados </p>
    </div><br>

</body>

</html>