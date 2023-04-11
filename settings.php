<?php 

include("header.php");

$infoo = mysql_query("SELECT * FROM users WHERE email='$login_cookie' ");
$info = mysql_fetch_assoc($infoo);

    if (isset($_POST['criar'])) {
        $nome = $_POST['nome'];
        $apelido = $_POST['apelido'];
        $pass = $_POST['pass'];
        
        if($nome == " "){
            echo"<h2>Digite seu nome</h2>";
        }elseif($apelido == " "){
            echo"<h2>Digite seu apelido</h2>";
        }elseif($pass == " "){
            echo"<h2>Digite sua palavra-passe</h2>";
        }else{
            $query = "UPDATE users SET `nome`='$nome', `apelido`='$apelido', `password`='$pass' WHERE email='$login_cookie' ";
            $data = mysql_query($query);
            if ($data) {
                header("Location: myprofile.php");
            }else{
                echo"<h2>Algo nao ocorreu como esperado...</h2>"; 
            }
        }


    }
    if (isset($_POST['cancelar'])) {
        header("Location: myprofile.php");


    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo/style-settings.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css' >
    
</head>
<body>
    <img name="logo" src="img/logo11.png" alt="Logo"><br>
    <h2><strong>Alterar Definições</strong></h2>
    <form method="POST">

    <input type="text" placeholder="Primeiro nome" value="<?php echo $info['nome']; ?>" name="nome"><br>
    <input type="text" placeholder="Apelido"value="<?php echo $info['apelido']; ?>" name="apelido"><br>
    <input type="password" placeholder="Escreva a sua palavra-passe" value="<?php echo $info['password']; ?>" name="pass"><br>
    <input type="submit" value="Alterar" name="criar">&nbsp;&nbsp;&nbsp;<input type="submit" value="Cancelar" name="cancelar">
    </form>
   
</body>
</html>