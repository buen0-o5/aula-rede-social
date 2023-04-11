<?php
include("header.php");

if (isset($_POST['save'])) {
    if ($_FILES["file"]["error"]>0) {
    echo "<script language='javascript' type='text/javascript'>alert('Tem que escolher uma foto')</script>";
    }else{
        $n = rand (0,1000000);
        $img = $n.$_FILES["file"]["name"];

        move_uploaded_file($_FILES['file']['tmp_name'], "upload/".$img);
        echo "Já está!";

        $query = "UPDATE users SET `img`='$img' WHERE `email`='$login_cookie'";
        $data = mysql_query($query);
        if($data){
            header("Location: myprofile.php");
        }else{
    echo "<script language='javascript' type='text/javascript'>alert('Ocorreu um erro ao atualizar sua foto...')</script>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="estilo/style-profilepic.css">
</head>

<body>
    <h2>Alterar foto de perfil...</h2><br><br>
    <form method="POST" enctype="multipart/form-data" id="perfil">
        <br>
        <h3>Mostrar ao mundo que és</h3><br>
        <h3>Adicionando uma foto de perfil...</h3><br>
        <input type="file" name="file"><br><br><br>
        <input type="submit" value="Guardar" name="save">
        <br><br>
    </form>
    <br><br><br>
    <p>&copy; Meet new Friends, 2022 - Todos os direitos reservados </p>
</body>

</html>