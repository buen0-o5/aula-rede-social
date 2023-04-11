<?php
include("header.php");

$pubs = mysql_query("SELECT * FROM amizades WHERE de='$login_cookie' or para='$login_cookie' ORDER BY id desc");
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="estilo/style-amigos.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    
</head>

<body>
    <h2>Amigos</h2>
   <?php
    while ($pub = mysql_fetch_assoc($pubs)) {
      if ($pub['de'] == $login_cookie) {
          $para = $pub['para'];
        $info = mysql_query("SELECT * FROM users WHERE email='$para'");
        $amigosinfo = mysql_fetch_assoc($info);
          echo '<div class="pub">
            <p>Amigos desde '. $pub["data"] . '</p>
            <span><a href="profile.php?id='.$amigosinfo['id'].'">'. $amigosinfo["nome"] .' '.$amigosinfo["apelido"].'</a></span></br>
            </div>';
        } else {
            $de = $pub['de'];
            $info = mysql_query("SELECT * FROM users WHERE email='$de'");
            $amigosinfo = mysql_fetch_assoc($info);
              echo '<div class="pub">
                <p>Amigos desde '. $pub["data"] . '</p>
                <span><a href="profile.php?id='.$amigosinfo["id"].'">'. $amigosinfo["nome"] . ' ' .$amigosinfo['apelido'].'<a/></span></br>
                </div>';
        }
    }
    ?>
    <br>
    <div id="rodape">
        <p>&copy; Meet new Friends, 2022 - Todos os direitos reservados </p>
    </div><br>

</body>

</html>