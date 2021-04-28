<?php
include "connect.php";

$id = $_GET['id'];

$result = $mysql->query("SELECT * FROM ong WHERE id = $id;");
$row = $result->fetch_assoc();

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
    require_once("includes/nav.php");
    ?>
    <main>
        <div class="p-3 justify-content-center">
            <div class="LOng">
                <img src="./imgs/<?php echo $row['img'];  ?>" alt="">
            </div>
            <div class="descricao bg-white lg-3 border border-3 border-primary px-5 py-2">
                <h2><?php echo $row['name']; ?></h2>
                <p><b>Descrição:</b> <?php echo $row['description'];  ?></p>
                <p><b>Endereço:</b> <?php echo $row['address'];  ?></p>
            </div>
        </div>
        <div class="adocao">
            <h1 >Animais para adoação nesta ONG</h1>
        </div>

        <div class="animals">
            <?php
            include "connect.php";

            $dados = $mysql->query("SELECT name, description, img, id FROM animal_adoption WHERE ong_id = $id;");
            while ($linha = mysqli_fetch_array($dados)) {
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>