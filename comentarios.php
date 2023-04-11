<?php
include("header.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}else {
    header("Location: ./");
}
$pubs = mysql_query("SELECT * FROM comentarios WHERE post='$id'");



if (isset($_POST['publish'])) {
        $texto = $_POST["texto"];
        $hoje = date("Y-m-d");


        $post = mysql_query("SELECT * FROM pubs WHERE id ='$id'"); 
        $postinfo = mysql_fetch_assoc($post);
        $userinfo = $postinfo['user'];


        if ($texto == "") {
            echo "<h3>texto não informado!</h3>";
        } else {
            $query = "INSERT INTO comentarios (user,texto,post,data) VALUES ('$login_cookie', '$texto','$id','$hoje')";
            $data = mysql_query($query) or die();
            if ($data) {
                $not = mysql_query("INSERT INTO notificacoes (`userde`,`userpara`,`tipo`,`post`,`data`) VALUES ('$login_cookie','$userinfo','2','$id','$hoje')");
                header("Location: comentarios.php?id=".$id);
            } else {
                echo "Ops... algo deu errado, tente novamente mais tarde";
            }
        }
   
}

?>
<!DOCTYPE html>
<html>

<head>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="estilo/style-comentarios.css">
</head>

<body>
    <div id="publish">
        <form method="POST" enctype="multipart/form-data">
            <br>
            <textarea placeholder="Escreva um novo post..." name="texto"></textarea>
            <input type="submit" value="Comentar" name="publish">
            


        </form>
    </div>
    <?php
    while ($pub = mysql_fetch_assoc($pubs)) {
        $email = $pub['user'];
        $saberr = mysql_query("SELECT * FROM users WHERE email='$email' ");
        $saber = mysql_fetch_assoc($saberr);
        $nome = $saber['nome'] . " " . $saber['apelido'];
      
        echo '<div class="pub" >
            <p><a href="profile.php?id=' . $saber['id'] . '">' . $nome . '</a> -' . $pub["data"] . '</p>
                <span>' . $pub['texto'] . '</span></br>
        </div>';
    }




    ?>
    <br>
    <div id="rodape">
        <p>&copy; Meet new Friends, 2022 - Todos os direitos reservados </p>
    </div><br>

</body>

</html>