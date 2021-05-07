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
                                  ong.address
                           FROM animal_adoption 
                           INNER JOIN ong ON (animal_adoption.ong_id = ong.id) 
                           WHERE animal_adoption.id = $id;");
$result->execute();

while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
    $name = $linha['name'];
    $description = $linha['description'];
    $img = $linha['img'];
    $address = $linha['address'];
}
?>

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
    <link rel="stylesheet" href="css/Aniamal_Profile.css">


    <title>Adoção-Perfil</title>

</head>

<body>
    <main class="p-3 d-flex justify-content-center">
        <div class="Perfil">
            <div class="img">
                <img src="./imgs/<?php echo $img; ?>" alt="Foto de um animal">
            </div>
            <div class="descricao bg-white shadow lg-3 border border-3 border-primary px-5 py-2">
                <h2><?php echo $name; ?></h2>
                <p><b>Descrição:</b> <?php echo $description; ?></p>
                <p><b>Endereço:</b> <?php echo $address; ?></p>
                <br>
                <strong> Adote este animal indo no endereço acima.</strong>
            </div>
        </div>
        <br><br><br><br><br><br><br><br>
    </main>
    <?php
    require_once("includes/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>