<?php 

include("db.php");

    if (isset($_POST['criar'])) {
        $nome = $_POST['nome'];
        $apelido = $_POST['apelido'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $data = date("y/m/d");

        $email_check = mysql_query("SELECT email FROM users WHERE email='$email'");
        $do_email_check = mysql_num_rows($email_check);
        if ($do_email_check >=1) {
            echo '<h3>Este email ja foi cadastrado faça seu login <a href="login.php"> aqui </a> </h3>';
        }elseif($nome == '' OR strlen($nome)<3) {
            echo "<h3>Escreva seu nome corretamente!</h3>";
        }elseif ($email == '' OR strlen($email)<10) {
            echo "<h3>Escreva seu E-mail corretamente!</h3>";
        }elseif ($pass == '' OR strlen($pass)<8) {
            echo "<h3>Escreva sua palavra-passe corretamente, deve ter mais que 8 caracteres!</h3>";
        }else{
            $query = "INSERT INTO users (`nome`,`apelido`,`email`,`password`,`data`) VALUES('$nome','$apelido','$email','$pass','$data')";
            $data = mysql_query($query) or die (mysql_error());
            if ($data) {
                setcookie("login", $email);
                header("Location:./");
            }else{
                echo "<h3>Desculpe, houve um erro ao finalizar seu registro...</h3>";
            }
        }
             
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css' >
    <style>
    *{
        font-family:'Montserrat',cursive;
    }
    img{
        display:block;
        margin:auto;
        margin-top: 20px;
        width: 200px;
    }
    form{
        text-align: center;
        margin: 20px;
    }
    input[type="text"]{
        border: 1px solid #CCC;
        width:250px;
        height: 25px;
        padding-left:10px;
        border-radius:3px;
        margin-top:10px;
    }
    input[type="email"]{
        border: 1px solid #CCC;
        width:250px;
        height: 25px;
        padding-left:10px;
        border-radius:3px;
        margin-top:10px;
    }
    input[type="password"]{
        border: 1px solid #CCC;
        width:250px;
        height: 25px;
        padding-left:10px;
        margin-top:10px;
        border-radius:3px;
    }
    input[type="submit"]{
        border: none;
        width: 170px;
        height: 30px;
        margin-top:20px;
        border-radius:3px;
        font-weight:bold;
    }
    input[type="submit"]:hover{
        background-color:#1E90FF;
        color: #ffff;
        cursor: pointer;
    }
    h2{
        text-align:center;
        margin-top: 20px;
        font-size:18px;

    }
    h3{
        text-align: center;
        color: #1E90FF;
        margin-top: 15px;
        font-weight: bolder;
    }
    a{
        text-decoration: none;
        color: #333;
    }
    </style>
</head>
<body>
    <img src="img/logo11.png" alt="Logo"><br>
    <h2><strong>Criando conta</strong></h2>
    <form method="POST">

    <input type="text" placeholder="Primeiro nome" name="nome"><br>
    <input type="text" placeholder="Apelido" name="apelido"><br>
    <input type="email" placeholder="Endereço de E-mail" name="email"><br>
    <input type="password" placeholder="Escreva a sua palavra-passe" name="pass"><br>
    <input type="submit" value="Criar uma conta" name="criar">
    </form>
    <h3>Ja possui uma conta? <a href="login.php"> Clique aqui para logar</a></h3>
</body>
</html>