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
    <link rel="stylesheet" href="css/index.css">


    <title>Companheiro Fiel</title>
</head>

<body class="bg-dark">
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
    ?>
    <!-- Header-->
    <header class="bg-light py-2">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center my-3">
                        <h1 class="display-5 fw-bolder text mb-2">Bem-vindo ao Companheiro Fiel</h1>
                        <p class="lead text mb-4">Somos uma equipe de desenvolvedores, e amamos
                            os animais, e temos como objetivo ajudar o maior número de animas possíveis.</p>
                        <hr />
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- carousel section-->
    <section class="servicos">
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
                </div>
                <div class="carousel-item">
                    <a href="./reportar.php">
                        <img class="d-block w-100" src="./imgs/servico-reporte.jpg" alt="Segundo Slide">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="./ongs.php">
                        <img class="d-block w-100" src="./imgs/servico-ong.jpg" alt="Terceiro Slide">
                    </a>
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
    </section>

    <!--Aplicativo-->
    <section class="bg-light py-2">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center my-2">
                        <hr />
                        <h1 class="display-5 fw-bolder text mb-2">Baixe Nosso Aplicativo</h1>
                        <p class="lead text mb-4">Com o nosso aplicativo tudo fica mais simples, você
                            pode reporta de qualquer lugar que esteja muita facilidade. Entre com sua conta
                            criada no site ou app, e faça já seus reportes.</p>
                        <a class="btn btn-secondary btn-lg" href="#">Download</a>
                        <hr />
                        <div class="container px-5">
                            <h2 class="text-center text font-alt mb-1">Em breve</h2>
                            <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center">
                                <img src="./imgs/google.png" alt="Img google play store" width="300" />
                            </div>
                        </div>
                        <hr />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Serviços -->
    <section class="bg-dark text-white py-5 border-bottom">
        <div class="container">
            <div class="text-center">
                <h2 class="text-white text-uppercase">Serviços</h2>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <img src="./imgs/patinha.png" width="70">
                    </span>
                    <h4 class="my-1">Adoção</h4>
                    <p class="texto">Conheça nosso sistema de adoções, com
                        todos animais de ongs cadastradas.
                    </p>
                    <a href="./adocao.php" class="btn btn-outline-success">Ir</a>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <img src="./imgs/patinha.png" width="70">
                    </span>
                    <h4 class="my-1">Reporte</h4>
                    <p class="texto">Use nosso sistema de reportes, para reportar
                        e ajudar um animal.
                    </p>
                    <a href="./reportar.php" class="btn btn-outline-success">Ir</a>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <img src="./imgs/patinha.png" width="70">
                    </span>
                    <h4 class="my-1">Ongs</h4>
                    <p class="texto">Cadastre ou olhe ongs cadastradas em nosso site,
                        e conheça esse trabalho maravilhoso.</p>
                    <a href="./ongs.php" class="btn btn-outline-success"> Ir </a>
                </div>
            </div>
    </section>

    <!--Campanha-->
    <section class="bg-light text-white py-3 border-bottom">
        <div class="campanha container">
            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="titulo"> Abril laranja é todo mês</h2>
                    <p class="texto-campanha">
                        Abril Laranja é o mês de prevenção da crueldade contra os animais, vamos conscientizar
                        todos para que <strong>não aconteça mais crueldade aos animais!!!</strong> Abril Laranja foi uma campanha
                        criada em 2006 pela ASPCA, que visa alertar sobre os maus-tratos que animais domésticos e domesticados
                        são vítimas todos os anos e dar punições mais severas aos agressores. Desde sua criação, vários países
                        no mundo aderiram à campanha, inclusive o Brasil.
                    </p>
                </div>
                <div class="col-md-5">
                    <img src="./imgs/abril-laranja.jpg" class="img-fluid" height="100" width="290">
                </div>
            </div>
        </div>
    </section>

    <!--Quem somos-->
    <section class="bg-dark py-2">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center my-3">
                        <hr />
                        <h2 class="display-5 fw-bolder text-white mb-2">O que é o Companheiro Fiel?</h2>
                        <p class="lead text-white mb-4 text-justify">
                            Companheiro Fiel é uma equipe de programadores apaixonado por animais,
                            e queremos poder ajudar os animais de alguma forma em nossa área de trabalho/estudo,
                            então criamos duas plataformas com o intuito e objetivo de ajudar ongs que resgatam
                            animais, para que essas ongs recebam reportes de todas as pessoas que também querem
                            ajudar os animais.
                        </p>
                        <hr />
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php
    require_once("includes/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/global.js"></script>
</body>

</html>