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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="css/resetcss.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/index.css">

    <title>Companheiro Fiel</title>
</head>

<body>
    <?php
    require_once("includes/nav.php");
    ?>
    <header class="servicos">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="./adocao.php">
                        <img class="d-block w-100" src="./imgs/servico-adocao.jpg" alt="Primeiro Slide">
                    </a>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Adoção</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <a href="./reportar.php">
                        <img class="d-block w-100" src="./imgs/servico-reporte.jpg" alt="Segundo Slide">
                    </a>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Reportar</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <a href="./ongs.php">
                        <img class="d-block w-100" src="./imgs/servico-ong.jpg" alt="Terceiro Slide">
                    </a>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Ongs</h5>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Próximo</span>
            </a>
        </div>
    </header>

    <section class="sobre">
        <h2>Sobre</h2>
        <p>Somos um site de divulgação de ongs, para que os animais em situações extremas
            consigam ajuda e que ongs possão ajudar esses animais. Lorem, ipsum dolor sit
            amet consectetur adipisicing elit. Repellendus pariatur cum officia fugiat ad
            illo omnis ullam, quam vel totam corporis? Deleniti suscipit repellendus facere
            necessitatibus, rerum provident ex similique. </p>
    </section>

    <?php
    require_once("includes/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>


</html>