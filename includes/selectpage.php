<?php
    $i = 1;
    $dados = $mysql->prepare("SELECT name, description, img, id FROM animal_adoption LIMIT 1");
    $dados->execute();

    $dados_pg = $mysql->prepare("SELECT name, description, img, id FROM animal_adoption");
    $dados_pg->execute();
    $count = $dados_pg->rowCount();
    $calculo = ceil($count/9);

    if (isset($_GET['pagina']) == $i){
        $url = $_GET['pagina'];
        $mody = (1*$url)-1;

        $dados = $mysql->prepare("SELECT name, description, img, id FROM animal_adoption LIMIT 1 OFFSET $mody");
        $dados->execute();

    }
    



?>