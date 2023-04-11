<?php
include("header.php");

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
 <link rel="stylesheet" href="estilo/style-pesquisar.css">
</head>

<body>
    <h2>Resultados da sua pesquisa</h2><br>    

    <?php
        $query = $_GET['query'];

        $min_length = 3;
        
        if(strlen($query) >= $min_length){
            $query = htmlspecialchars($query);

            $query = mysql_real_escape_string($query);

            $raw_results = mysql_query("SELECT * FROM users WHERE (`nome` LIKE '%".$query."%')") or die (mysql_error());
            
            if (mysql_num_rows($raw_results) >0) {
                echo "<br/><br/>";
                while ($results = mysql_fetch_array($raw_results)) {
                    echo '<a href="profile.php?id='.$results["id"].' " name="p"><br/><p name="p"><h3>'.$results['nome'].' '.$results['apelido'].'</h3></p><br/><hr/><br/></a>';
                }
            }else {
                echo "<br/><h3>Não foram encontrado resultados... </h3>";
            }
         }else {
            echo "<br/><h3>Tem que escrever pelo menos 3 letras...</h3>";
         }
         




    ?>
</body>

</html>