<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!--Requisitos de tags meta-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--ico-->
    <link rel="shortcut icon" type="image" href="./imgs/CF.ico">

    <!--Css-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/resetcss.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/Animal_Profile.css">


    <title>Adoção-Perfil</title>

</head>

<body>
    <?php

    //Iniciando sessão
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (isset($_SESSION['email']) == true) {
        //Logou, então continua com as valida;'oes
        require_once("includes/nav.php");
    } else { //Não logou então volta para a página inicial
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_unset();
        session_destroy();
        require_once("includes/nav.php");
    }

    include "connect.php";

    $id = $_GET['id'];

    $result = $mysql->prepare("SELECT animal_adoption.*, 
                                    o.*,
                                    a.location_address,
                                    a.location_number,
                                    a.location_district,
                                    a.location_state
                            FROM animal_adoption 
                                INNER JOIN ong o ON (animal_adoption.ong_id = o.id)
                                INNER JOIN address a ON (o.address_id = a.id) 
                            WHERE animal_adoption.id = $id;");
    $result->execute();

    while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {

        //informações do animal
        $img = $linha['animal_photo'];
        $name = $linha['animal_name'];
        $description = $linha['animal_description'];
        $animal_age = $linha['animal_age'];
        $animal_gender = $linha['animal_gender'];
        $animal_race = $linha['animal_race'];
        $animal_category = $linha['animal_category'];

        //informações de contato com a ong
        $animal_ong_since = $linha['animal_ong_since'];
        $ong_business_hours = $linha['ong_business_hours'];

        $address = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";
    }
    ?>
    <main class="container p-2 w-100 h-80 justify-content-center">
        <div class="img">
            <img src="./imgsUpdate/<?php echo $img; ?>" class="p-2 rounded float-left" alt="Foto de um animal">
        </div>
        <div class="descricao bg-white shadow lg-3 border border-3 border-primary px-5 py-2">
            <h2><?php echo $name; ?></h2>
            <p><b>Descrição:</b> <?php echo $description; ?></p>
            <p><b>Idade:</b> <?php echo $animal_age; ?></p>
            <p><b>Gênero:</b> <?php echo $animal_gender; ?></p>
            <p><b>Raça:</b> <?php echo $animal_race; ?></p>
            <p><b>Tamanho:</b> <?php echo $animal_category; ?></p>
            <p><b>Na Ong desde:</b> <?php echo $animal_ong_since; ?></p>
            <div class="linha-horizontal m-2"></div>
            <strong> Adote este animal indo no endereço abaixo:</strong>
            <p><b>Endereço:</b> <?php echo $address; ?></p>
            <p><b>Horario de Atendimento:</b><?php echo $ong_business_hours; ?></p>
        </div>
    </main>
    <?php
    //incluindo o footer na página
    require_once("includes/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>