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
                    <!--<div class="carousel-caption d-none d-md-block">
                        <h5>Adoção</h5>
                    </div>-->
                </div>
                <div class="carousel-item">
                    <a href="./reportar.php">
                        <img class="d-block w-100" src="./imgs/servico-reporte.jpg" alt="Segundo Slide">
                    </a>
                    <!--<div class="carousel-caption d-none d-md-block">
                        <h5>Reportar</h5>
                    </div>-->
                </div>
                <div class="carousel-item">
                    <a href="./ongs.php">
                        <img class="d-block w-100" src="./imgs/servico-ong.jpg" alt="Terceiro Slide">
                    </a>
                    <!--<div class="carousel-caption d-none d-md-block">
                        <h5>Ongs</h5>
                    </div>-->
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

    <section class="reporte">
        <h2 class="titulo-reporte">Reporte</h2>
        <div>
            <p class="texto-reporte">
                Companheiro Fiel conta com uma função de reporte, o reporte é uma forma de aproximar uma pessoa
                do dia-dia com uma ong, funciona da seguinte maneira: Através do nosso site ou do nosso aplicativo,
                você pode reportar de qualquer lugar, desde que, esteja conectado a internet.
                <a href="./reportar.php">Reporte agora!</a>
            </p>
        </div>
    </section>

    <section class="campanha">
        <h2 class="titulo"> Abril laranja é todo mês</h2>
        <div class="img-campanha">
            <img src="./imgs/abril-laranja.jpg" class="img-fluid" height="400" width="250">
        </div>
        <div>
            <p class="texto-campanha">
                Abril Laranja é o mês de prevenção da crueldade contra os animais, vamos conscientizar
                todos para que <strong>não à crueldade contra os animais!!!</strong> Abril Laranja foi uma campanha
                criada em 2006 pela ASPCA, que visa alertar sobre os maus-tratos que animais domésticos e domesticados
                são vítimas todos os anos e dar punições mais severas aos agressores. Desde sua criação, vários países
                no mundo aderiram à campanha, inclusive o Brasil.
            </p>
        </div>
    </section>

    <section class="Sobre">
        <h2 class="titulo-sobre">Sobre Companheiro Fiel</h2>
        <div>
            <p class="texto-sobre">
                Somos uma equipe de desenvolvedores realizando um tcc, amamos todos os animais,
                e temos como objetivo ajudar o maior numero de animas possiveis. Visando que em 2020, após o início
                do isolamento provocado pela pandemia do novo coronavírus, o abandono de animails aumentou por conta
                de fake news e outro fatores já existentes.
            </p>
        </div>
    </section>

    <section class="adote">
        <h2 class="titulo-adote">Adote</h2>
        <div class="img-adote">
            <img src="./imgs/adote-nao-compre.jpg" class="img-fluid" height="500" width="500" >
        </div>
        <div>
            <p class="texto-adote">
                Milhares de animais estão abandonados nas ruas e passam por muito sofrimento,
                pois não têm a devida atenção e um lar de verdade. Ao adotar, você ajuda a reduzir
                esse número e tem a maior alegria que é mudar o destino de um animal sozinho. Ao adotar,
                você vai receber toda a gratidão em forma de amor e carinho. Eles são muito companheiros,
                leais e amam da forma mais pura. Porém para adotar, é necessário ter responsabilidade,
                pois não é um bichinho de pelúcia. Os animais têm muitas necessidades como fome, sono
                e atenção, além disso, precisam ser vacinados, alimentados e bem cuidados. Se você não
                tem condições de dar a devida atenção, não adote! Seja consciente.
                <a href="./adocao.php">Adote agora!</a>
            </p>
        </div>
    </section>

    <?php
    require_once("includes/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>


</html>