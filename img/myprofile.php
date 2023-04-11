<?php
include("header.php");

$id = $_GET["id"];
$saberr = mysql_query("SELECT * FROM users WHERE email='login_cookie'");
$saber = mysql_fetch_assoc($saberr);
$email = $saber['email'];



$pubs = mysql_query("SELECT * FROM pubs WHERE user='$email' ORDER BY id desc");
?>
<!DOCTYPE html>
<html>

<head>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sono:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sono:wght@700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        h2 {
            text-align: center;
            font-size: 30px;
            padding-top: 30px;
            color: rgb(64, 30, 255);
            font-family: 'Sono', sans-serif;

        }

        img#profile {
            width: 100px;
            height: 100px;
            display: block;
            margin: auto;
            margin-top: 30px;
            border: 9px solid rgb(209, 233, 255);
            background-color: rgb(209, 233, 255);
            border-radius: 10px;
            margin-bottom: -30px;




        }

        div#menu {
            width: 300px;
            height: 120px;
            display: block;
            margin: auto;
            border: none;
            border-radius: 5px;
            background-color: rgb(209, 233, 255);
            text-align: center;
        }

        div#menu input {
            height: 25px;
            background-color: #FFF;
            border: none;
            border-radius: 3px;
            font-family: 'Sono', sans-serif;
            font-size: 18px;
            margin-left: 10px;
            margin-right: 10px;
            cursor: pointer;
        }
        div#menu input[name="add"]{
            margin-right: 40px;
        }
        div#menu input[type="submit"]:hover{
            height: 25px;
            border: none;
            border-radius: 3px;
            background-color:rgba(255, 255, 255, 0.726);
            color: rgb(64, 30, 255);
            cursor: pointer;
            
            
        }

        div.pub {
            width: 400px;
            min-height: 70px;
            max-height: 1000px;
            display: block;
            margin: auto;
            border: none;
            border-radius: 5px;
            background-color: #FFF;
            box-shadow: 0 0 6px #A1A1A1;
            margin-top: 30px;
        }

        div.pub a {
            color: #666;
            text-decoration: none;

        }

        div.pub a:hover {
            color: #111;
            text-decoration: none;
        }

        div.pub p {
            scroll-margin-left: 10px;
            content: #666;
            padding-top: 10px;
        }

        div.pub span {
            display: block;
            margin: auto;
            width: 380px;
            margin-top: 10px;
        }

        div.pub img {
            display: block;
            margin: auto;
            width: 100%;
            margin-top: 10px;
            border-top: 1px solid rgba(0, 0, 0, 0.082);
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        div#rodape {
            bottom: 0;
            text-align: center;
            color: #666;
            font-size: 13px;
        }
    </style>


</head>

<body>
    <?php
    if ($saber["img"] == "") {
        echo '<img src="img/user.png" id="profile">';
    } else {
        echo '<img src="upload/' . $saber["img"] . '" id="profile">';
    }


    ?>
    <div id="menu">
        <form method="POST">
        <h2><?php echo $saber['nome'] . " " . $saber['apelido']; ?></h2><br>
        <input type="submit" value="Alterar Inf" name="settings"><input type="submit" name="amigos" value="Ver amigos">;
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