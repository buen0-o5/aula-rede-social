<?php
include("header.php");

$pubs = mysql_query("SELECT 
        T.id,
        T.user,
        T.texto,
        T.imagem,
        T.data,
        U.de,
        U.para,
        U.aceite
    FROM
        pubs AS T,
        amizades AS U
    WHERE
    T.user = U.de AND U.para = '$login_cookie' AND U.aceite='1'
    OR T.user = U.para AND U.de ='$login_cookie' AND U.aceite='1'
    order by T.id DESC;");








if (isset($_POST['publish'])) {
    if ($_FILES["file"]["error"] > 0) {
        $texto = $_POST["texto"];
        $hoje = date("Y-m-d");

        if ($texto == "") {
            echo "<h3>texto não informado!</h3>";
        } else {
            $query = "INSERT INTO pubs (`user`,`texto`,`data`) VALUES ('$login_cookie', '$texto','$hoje')";
            $data = mysql_query($query) or die();//mysql_query() envia uma consulta (para o banco de dados
            if ($data) {
                header("Location: ./"); //direcionado para index do projeto
            } else {
                echo "Ops... algo deu errado, tente novamente mais tarde";
            }
        }
    } else {
        $n = rand(0, 100000); //é criado um gerando de numero aleatoria
        $img = $n . $_FILES["file"]["name"]; 
        /* aqui é concatenado o numero aleatorio criado acima poara juntar com o endereço da imagem, mesmo que for salvo a mesma imagem o endereço ira mudar*/ 

        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $img); 
        //comando que paz o upload da imagem e salva na pasta endicada

        $texto = $_POST['texto'];
        $hoje = date("Y-m-d");

        if ($texto == "") {
            echo "<h3>texto não informado!</h3>";
        } else {
            $query = "INSERT INTO pubs (`user`,`texto`,`imagem`,`data`) VALUES ('$login_cookie','$texto','$img','$hoje')";
            $data = mysql_query($query) or die();
            if ($data) {
                header("Location: ./");
            } else {
                echo "Ops... algo deu errado, tente novamente mais tarde";
            }
        }
    }
}

if (isset($_GET["love"])) {
    love();
}

function love(){
    $login_cookie = $_COOKIE['login'];
    $publicacaoid = $_GET['love'];
    $data = date("Y/m/d");
    
    $post = mysql_query("SELECT * FROM pubs WHERE id ='$publicacaoid'"); 
    $postinfo = mysql_fetch_assoc($post);
    $userinfo = $postinfo['user'];

    $ins = "INSERT INTO loves (`user`,`pub`,`date`) VALUES ('$login_cookie','$publicacaoid','$data')";
    $conf = mysql_query($ins) or die (mysql_error());
    if ($conf) {
        $not = mysql_query("INSERT INTO notificacoes (`userde`,`userpara`,`tipo`,`post`,`data`) VALUES ('$login_cookie','$userinfo','1','$publicacaoid','$data')");
        header("Location: index.php#".$publicacaoid);
    }else {
        echo "<h3>Erro</h3>".mysql_error();
    }
}

if (isset($_GET["unlove"])) {
    unlove();
}

function unlove(){
    $login_cookie = $_COOKIE['login'];
    $publicacaoid = $_GET['unlove'];
    $data = date("Y/m/d");

    $del = "DELETE FROM loves WHERE `user`='$login_cookie' AND `pub`='$publicacaoid' ";
    $conf = mysql_query($del) or die (mysql_error());
    if ($conf) {
        header("Location: index.php#".$publicacaoid);
    }else {
        echo "<h3>Erro</h3>".mysql_error();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="estilo/style-index.css">
</head>

<body>
    <div id="publish">
        <form method="POST" enctype="multipart/form-data">
            <br>
            <textarea placeholder="Escreva uma publicação nova" name="texto"></textarea>
            <label for="file-input">
                <img src="img/camera.png" title="Inserir uma fotografia" alt="Camera" id="camera">
            </label>
            <input type="submit" value="Publicar" name="publish">
            <input type="file" id="file-input" name="file" hidden>


        </form>
    </div>
    <?php
    while ($pub = mysql_fetch_assoc($pubs)) {
        $email = $pub['user'];
        $saberr = mysql_query("SELECT * FROM users WHERE email='$email' ");
        $saber = mysql_fetch_assoc($saberr);
        $nome = $saber['nome'] . " " . $saber['apelido'];
        $id = $pub['id'];
        $saberloves = mysql_query("SELECT * FROM loves WHERE pub='$id'");
        $loves = mysql_num_rows($saberloves);

        if ($pub['imagem'] == "") {
            echo '<div class="pub" id="' . $id . '">
            
            <a href="comentarios.php?id='.$id.'"><img id="comentar" src="img/chat.png" ></a>


            <p><a href="profile.php?id=' . $saber['id'] . '">' . $nome . '</a> -' . $pub["data"] . '</p>
            <span>' . $pub['texto'] . '</span></br>
            </div>
            <div id="love">';
            $email_check = mysql_query("SELECT user FROM loves WHERE pub='$id' AND user='$login_cookie'");
            $do_email_check = mysql_num_rows($email_check);
            if ($do_email_check >=1) {
                $loves = $loves -1;
                echo '<p><a href="index.php?unlove='.$id.'">Gostei<a> | tu e mais '.$loves.' gostaram disto </p> ';
            }else {
                echo '<p><a href="index.php?love='.$id.'">Gostar<a> |  '.$loves.' gostaram disto </p> ';
            }
            echo '</div>';
        } else {
            echo '<div class="pub" id="' . $id . '">
            <a href="comentarios.php?id='.$id.'"><img id="comentar" src="img/chat.png" ></a>
            <p><a href="profile.php?id=' . $saber['id'] . '">' . $nome . '</a> -' . $pub["data"] . '</p>
            <span>' . $pub['texto'] . '</span>
            <img src="upload/' . $pub["imagem"] . '"/>
            </div>
            <div id="love">';
            $email_check = mysql_query("SELECT user FROM loves WHERE pub='$id' AND user='$login_cookie'");
            $do_email_check = mysql_num_rows($email_check);
            if ($do_email_check >=1) {
                $loves = $loves -1;
                echo '<p><a href="index.php?unlove='.$id.'">Gostei<a> | tu e mais '.$loves.' gostaram disto </p> ';
            }else {
                echo '<p><a href="index.php?love='.$id.'">Gostar<a> |  '.$loves.' gostaram disto </p> ';
            }
            echo '</div>';
        }
    }




    ?>
    <br>
    <div id="rodape">
        <p>&copy; Meet new Friends, 2022 - Todos os direitos reservados </p>
    </div><br>

</body>

</html>