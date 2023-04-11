<?php
include("db.php");

$login_cookie = $_COOKIE['login'];
if(!isset($login_cookie)){ 
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="estilo/style-header.css">
   <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css' >
</head>
<body>
    <div id="topo">
    <a href="index.php"><img src="img/logo11.png" alt="Logo"
name="logo"></a>
    <form method="GET" action="pesquisar.php">
    <input type="text" placeholder="Pesquisa alguém..." name="query" autocomplete="off" ><input type="submit" hidden>
    </form>
    
        <a href="inbox.php"><img src="img/chat3.png" width="50px" alt="Chat" name="menu"></a>
        <a href="notificacoes.php"><img src="img/sino.png" width="45px" alt="Chat" name="menu"></a>
        <a href="myprofile.php"><img src="img/perfil.ico" width="50px" alt="Perfil" name="menu"></a>
    </div>
    
</body>
</html>