<?php
include("header.php");
    $id = $_GET['id'];

    $tudo = mysql_query("SELECT * FROM users WHERE id='$id'");
    $saber = mysql_fetch_assoc($tudo);
    
    $email = $saber['email'];
   
    if (isset($_POST["enviar"])){
        if ($_FILES["file"]["error"]>0) {
            echo "<script language='javascript' type='text/javascript'>alert('Tem que escolher uma foto')</script>";
            }else{
                $n = rand (0,1000000);
                $img = $n.$_FILES["file"]["name"];
        
                move_uploaded_file($_FILES['file']['tmp_name'], "upload/".$img);
                echo "Já está!";

                $mensagem = $_POST["mensagem"];
                $data = date("Y/m/d");
        
                $query = "INSERT INTO mensagens (`de`,`para`,`texto`,`imagem`, `status`,`data`) VALUES ('$login_cookie','$email','".mysql_real_escape_string($msg)."','$img',0, '$data')";
                $data = mysql_query($query);
                if($data){
                    header("Location: chat.php?from=".$id);
                }else{
            echo "<script language='javascript' type='text/javascript'>alert('Ocorreu um erro ao 
            enviar sua foto...')</script>";
                }
            }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
    <link rel="stylesheet" href="estilo/style-image.css">
    </head>
    <body>
    <br/>
    <h2>Chat</h2><br/>
    <span>Enviar uma imagem</span><br/><br/><br/>
    <p>Primeiro, escreva algo (opcional:)</p>
    <br/>
    <form method="POST" enctype="multipart/form-data">
    <input type="text" name="mensagem" placeholder="Escreva uma mensagem(opcional)">
    <br/><br/><br/>
    <p>Escolha uma fotografia:</p>
    <input type="file" name="file"/>
    <br/><br/>
    <input type="submit" name="enviar" value="Enviar">
    </form>
    </body>
</html>