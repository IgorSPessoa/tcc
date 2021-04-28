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
    <link rel="stylesheet" href="css/ongs.css">


    <title>Ongs</title>
</head>

<body>
    <?php
    require_once("includes/nav.php");
    ?>
    <h1 class="text-center">Lista de Ongs</h1>
    <main class="p-3">
        <div class="animals">
            <?php
            include "connect.php";

            $dados = $mysql->query("SELECT id, name, description, img FROM ong;");

            while ($linha = mysqli_fetch_array($dados)) {
                //<p>$linha[2]</p> vai depois de linha 1.
                echo "<div class='animal bg-white shadow lg-3 border border-3 border-primary px-5 py-2'>
                            <span class='text-center'>$linha[1]</span>
                            
                            <img src='imgs/$linha[3]' alt='Imagem da ong'>
                            <br><br>
                            <a href='ong_profile.php?id=$linha[0]' class='button'>Visualizar perfil</a>
                            <br><br>
                        </div>";
            }

            ?>
        </div>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
    </main>
    <?php
    require_once("includes/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>