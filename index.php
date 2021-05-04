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
    <link rel="stylesheet" href="css/index.css">

    <title>Companheiro Fiel</title>
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
                        <h5></h5>
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
</body>


</html>