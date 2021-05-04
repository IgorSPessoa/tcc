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
    <link rel="stylesheet" href="css/responsiveToBoot.css">

    <title>Reportar</title>
</head>

<body class="bg-light">
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

    <main class="p-3">
        <div class="text-center">
            <h1>Animal em perigo? Reporte aqui!</h1>
            <p>Nossas ONG cadastradas serão informadas sobre isto.</p>
            <br>
        </div>

        <form class="bg-white shadow lg-3 border border-3 border-primary px-5 py-5" action="controller/emulator_animal_report.php" method="post">

            <h3>Sobre você</h3>
            <label for="fname">Seu nome completo:</label>
            <input type="text" id="nome" name="nome" required><br><br>
            <label for="lname">Seu telefone:</label>
            <input type="text" id="telefone" name="telefone" required><br><br>

            <h3>Sobre o animal</h3>
            <label for="fname">Qual é a situação do animal?</label>
            <input type="text" id="situacao_animal" name="situacao_animal" required><br><br>

            <label for="fname">Descreva o animal:</label>
            <input type="text" id="animal_descrição" name="animal_descrição" required><br><br>

            <label for="lname">Anexe uma foto do animal:</label>
            <input type="file" id="foto_animal" name="foto_animal"><br><br>

            <h3>Localização</h3>
            <label for="fname">Endereço em que foi visto pela última vez:</label>
            <input type="text" id="endereco" name="endereco" required><br><br>

            <label for="lname">Observações sobre localização do animal, ponto de referência:</label>
            <input type="text" id="observacao" name="observacao" required><br><br>

            <label for="lname">Anexe a foto de um ponto de referência:</label>
            <input type="file" id="foto_animal" name="foto_animal"><br><br>

            <input class="btn btn-primary mb-3 w-100" type="submit" value="Reportar">

        </form>
    </main>
    <?php
    require_once("includes/footer.php");
    ?>
</body>


</html>