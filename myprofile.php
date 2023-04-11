<?php
include("header.php");


$saberr = mysql_query("SELECT * FROM users WHERE email='$login_cookie'");
$saber = mysql_fetch_assoc($saberr);
$email = $saber['email'];

$pubs = mysql_query("SELECT * FROM pubs WHERE user='$email' ORDER BY id desc");

if (isset($_POST['settings'])){
    header("Location: settings.php");
}

if (isset($_POST['amigos'])){
    header("Location: amigos.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="estilo/style-myprofile.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    
</head>

<body>
    <h3>Este é seu perfil, é possivel editalo</h3>
    <?php
    if ($saber["img"] == "") {
        echo '<a href="profilepic.php" style="width: 100px; display: block;
        margin: auto; "><img src="img/user.png" id="profile"></a>';
    } else {
        echo '<a href="profilepic.php" style="width: 100px; display: block;
        margin: auto; "><img src="upload/' . $saber["img"] . '" id="profile"></a>';
    }


    ?>
    <div id="menu">
        <form method="POST">
        <h2><?php echo $saber['nome'] . " " . $saber['apelido']; ?></h2><br>

        <input type="submit" value="Alterar Info" name="settings">&nbsp;&nbsp;<input type="submit" name="amigos" value="Ver Amigos" >
        </form>
    </div>
    <?php
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
            <p><a href="profile.php?id=' . $saber['id'] . '">' . $nome . '</a> -' . $pub["data"] . '</p>
            <span>' . $pub['texto'] . '</span>
            <img src="upload/' . $pub["imagem"] . '"/>
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