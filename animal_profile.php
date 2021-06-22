<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!--Requisitos de tags meta-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--ico-->
    <link rel="shortcut icon" type="image" href="./imgs/CF.ico">
    <link rel="stylesheet" href="dashboard/plugins/fontawesome/css/all.min.css">

    <!--Css-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/resetcss.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/Animal_Profile.css">


    <title>Adoção</title>
</head>

<body>
    <?php

    //Iniciando sessão
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (isset($_SESSION['email']) == true) {
        //Logou, então continua com as validações
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

    //verificar se existe algo no id 
    if ($id == "") {
        header('Location: adocao.php?msg=error_id');
    }
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

    //verficando se houve resultado para na query
    $rows = $result->rowCount();
    if ($rows >= 1) { // se existe algum resultado, irá pegar os dados 
        while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {

            //informações do animal
            $img = $linha['animal_photo'];
            $name = $linha['animal_name'];
            $description = $linha['animal_description'];
            $animal_age = $linha['animal_age'];
            $animal_gender = $linha['animal_gender'];
            $animal_race = $linha['animal_race'];
            $animal_category = $linha['animal_category'];
            $animal_weight = $linha['animal_weight'];
            $animal_ong_since = $linha['animal_ong_since'];

            //traduzindo os campos de genero
            if ($animal_gender === "male") {
                $animal_gender = "Masculino";
            } elseif ($animal_gender === "female") {
                $animal_gender = "Feminino";
            }

            //traduzindo os campos de tamanho
            if ($animal_category === "small") {
                $animal_category = "Pequeno";
            } elseif ($animal_category === "average") {
                $animal_category = "Médio";
            } elseif ($animal_category === "big") {
                $animal_category = "Grande";
            }

            //informações de contato com a ong
            $ong_name = $linha['ong_name'];
            $ong_phone = $linha['ong_phone'];
            $ong_email = $linha['ong_email'];
            $ong_business_hours = $linha['ong_business_hours'];
            $address = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";
        }
    } else { //se não existir resultados na query, irá redirecionar com um erro
        header('Location: adocao.php?msg=error_information');
    }

    ?>
    <div class="container">
        <div class="text-center p-2">
            <h2 class="text-uppercase">Adote</h2>
        </div>
    </div>
    <div class="container">
        <div class="main-body">

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">

                    <div class="card border border-dark">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="./imgsUpdate/<?php echo $img; ?>" alt="Foto de um animal" class="rounded p-1" width="240">
                                <div class="mt-3">
                                    <h4><?php echo $name; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3 border border-dark">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between text-center flex-wrap">
                                <h6 class="mb-0">Adote Indo até a ONG:</h6>
                                <span class="text-secondary"><?php echo $ong_name; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Endereço:</h6>
                                <span class="text-secondary"><?php echo $address; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0 p-1">Horario de Atendimento:</h6>
                                <span class="p-1 text-secondary"><?php echo $ong_business_hours; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0 p-1">Contato:</h6>
                                <span class="text-secondary"><?php echo 'Telefone:' . $ong_phone ?></span>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="col-md-8">
                    <div class="card mb-3 border border-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Descrição:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span><?php echo $description; ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Idade:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span> <?php echo $animal_age; ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Gênero:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span> <?php echo $animal_gender; ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Raça:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span> <?php echo $animal_race; ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Tamanho:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span> <?php echo $animal_category; ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Peso:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span> <?php echo $animal_weight; ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Na ONG desde:</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span><?php echo $animal_ong_since; ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Sobre adoção</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <span> Adotar, é necessário ter responsabilidade, pois não é um bichinho de pelúcia. Os animais têm muitas necessidades como fome,
                                        sono e atenção, além disso, precisam ser vacinados, alimentados e bem cuidados. Se você não tem condições de dar a devida atenção, não adote! Seja consciente.
                                    </span>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    //incluindo o footer na página
    require_once("includes/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>