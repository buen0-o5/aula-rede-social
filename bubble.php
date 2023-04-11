<?php
include("db.php");

$login_cookie = $_COOKIE['login'];

$infoo = mysql_query("SELECT * FROM users WHERE email='$login_cookie'");
$info = mysql_fetch_assoc($infoo);

$id = $_GET['from'];

$tudo = mysql_query("SELECT * FROM users WHERE id='$id'");
$saber = mysql_fetch_assoc($tudo);

$email = $saber['email'];

$sql = mysql_query("SELECT * FROM mensagens WHERE para='$login_cookie' AND de='$email' OR de='$login_cookie' AND para='$email'");

$mysql = "UPDATE mensagens SET status=1 WHERE para='$login_cookie' AND de='$email'";
$update = mysql_query($mysql);
?>


<html lang="pt-br">
<head>
    <meta http-equiv="refresh" constant=5;>
    <link rel="stylesheet" href="estilo/style-bubble.css">
    <style>
    html{
    font-family: Ubuntu, sans-serif;
    -webkit-animation: fadein 0s; /* Safari, Chrome and Opera > 12.1 */
    -moz-animation: fadein 0s; /* Firefox < 16 */
    -ms-animation: fadein 0s; /* Internet Explorer */
    -o-animation: fadein 0s; /* Opera < 12.1 */
    animation: fadein 0s;
}
    
    </style>
</head>
<body>
    <?php
    while ($msg=mysql_fetch_assoc($sql)) {
        if ($msg['de']==$login_cookie) {
            if ($msg["imagem"]=="") {
                echo '<div class="bubble"> 
                <br/>
                <span name="msgl">'.$msg["texto"]. '<span>
                <br/><br/>
                <p>'.$msg["data"].'</p>
                <br/>
                </div><br/>';
            }else {
                echo '<div class="bubble"> 
                <br/>
                <span name="msgl">'.$msg["texto"]. '<span>
                <br/>
                <img src="upload/'.$msg["imagem"].'"/>
                <br/>
                <p>'.$msg["data"].'</p>
                <br/>
                </div><br/>';  
            }
        }else {
                if ($msg["imagem"]=="") {
                    echo '<div class="bubble2"> 
                    <br/>
                    <span name="msgl">'.$msg["texto"]. '<span>
                    <br/><br/>
                    <p>'.$msg["data"].'</p>
                    <br/>
                    </div><br/>';
                }else {
                    echo '<div class="bubble2"> 
                    <br/>
                    <span name="msgl">'.$msg["texto"]. '<span>
                    <br/>
                    <img src="upload/'.$msg["imagem"].'"/>
                    <br/>
                    <p>'.$msg["data"].'</p>
                    <br/>
                    </div><br/>';  
                }
        }
    }

    
    ?> 
</body>
</html>