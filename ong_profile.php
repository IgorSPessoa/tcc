<?php
include "connect.php";

$id = $_GET['id'];

$result = $mysql->prepare("SELECT * FROM ong WHERE id = $id;");
$result->execute();

while($linha = $result->fetch(PDO::FETCH_ASSOC)){
    $name = $linha['name'];
    $description =$linha['description'];
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
    <link rel="stylesheet" href="css/Ong_Profile.css">


    <title>Perfil Ong</title>
</head>

<body>
    <?php
        //Iniciando sessão
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
        if(isset($_SESSION['email']) == true){
            //Logou, então continua com as valida;'oes
            require_once("includes/nav.php");
        }else{//Não logou então volta para a página inicial
            if(session_status() !== PHP_SESSION_ACTIVE){
                session_start();
            }
            session_unset();
            session_destroy();
            require_once("includes/nav.php");
        }
    ?>
    <main>
        <div class="p-3 justify-content-center">
            <div class="LOng">
                <img src="./imgs/<?php echo $img;  ?>" alt="">
            </div>
            <div class="descricao bg-white lg-3 border border-3 border-primary px-5 py-2">
                <h2><?php echo $name; ?></h2>
                <p><b>Descrição:</b> <?php echo $description;  ?></p>
                <p><b>Endereço:</b> <?php echo $address;  ?></p>
            </div>
        </div>
        <div class="adocao">
            <h1 >Animais para adoação nesta ONG</h1>
        </div>

        <div class="animals">
            <?php

            $dados = $mysql->prepare("SELECT name, description, img, id FROM animal_adoption WHERE ong_id = $id;");
            $dados->execute();

            while ($linha = $dados->fetch(PDO::FETCH_BOTH)) {
                echo "<div class='animal bg-white shadow lg-3 border border-3 border-primary px-5 py-2'>
                            <span>$linha[0]</span>
                            <p>$linha[1]</p>
                            <img src='imgs/$linha[2]' alt='Imagem de um cachorro'>
                            <br><br>
                            <a href='animal_profile.php?id=$linha[3]' class='btn btn-outline-dark'>Visualizar informações</a>
                            <br><br>
                        </div>";
            }
            ?>
        </div>
        <br>
    </main>
    <?php
    require_once("includes/footer.php");
    ?>
</body>

</html>