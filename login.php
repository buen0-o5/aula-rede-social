<?php 

include("db.php");

if (isset($_POST['entrar'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $verifica = mysql_query("SELECT * FROM users WHERE email='$email' AND password='$pass'");
    if (mysql_num_rows($verifica)<=0) {
        echo "<h3>Palavra-passe ou E-mail errador!</h3>";
    }else{
        setcookie("login", $email);
        header("Location: ./");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="estilo/style-login.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css' >

    
</head>
<body>
    <img src="img/logo11.png" alt="Logo"  ><br>
    <h2><strong>Fazer login</strong></h2>
    <form method="POST">
    <input type="email" placeholder="Endereço de E-mail" name="email"><br>
    <input type="password" placeholder="Escreva a sua palavra-passe" name="pass"><br>
    <input type="submit" value="Entrar" name="entrar">
    </form>
    <h3>Ainda não possui uma conta? <a href="registrar.php"> Crie uma hoje!</a></h3>
</body>
</html>