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
    <link rel="stylesheet" href="css/user_dashboard.css">

    <title>Home User</title>
</head>

<body>
    <?php
    //Iniciando o sessão
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    //verificando se tem um email por SESSION
    if (isset($_SESSION['email']) == true) {
        //Logou, então o nav vai ser incluido
        require_once("includes/nav.php");
    } else { //Não logou então volta para a página inicial
        unset($_SESSION['email']);
        unset($_SESSION['acc_type']);
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_unset();
        session_destroy();
        echo "<script language='javascript' type='text/javascript'>window.location = ' login.php';</script>";
    }
    ?>
    <main>
        <div class="d-flex justify-content-center">
            <img src="./imgs/user.gif" alt="">
        </div>
        <div class="User bg-dark">
            <h2><?php echo $_SESSION['name']; ?></h2>
            <p>Reports enviados: 90</p>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div class="d-flex flex-row-reverse">
                <a href="logout.php" class="button btn btn-danger"> Sair</a>
            </div>
        </div>
    </main>
    <?php
    require_once("includes/footer.php");
    ?>
    <script src="dashboard/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="dashboard/plugins/bootstrap/js/bootstrap.min.js"></script>
    <?php 
        //verificando se existe uma mensagem para o usúario
        if(isset($_GET['msg'])) {
            
            $msg = $_GET['msg']; // colocando a mensagem em uma variavel
            $_COOKIE['msg'] = $msg; // Colocando a variavel em um cookie, para conseguir pegar no outro script

            $name = $_SESSION['name'];// Colocando o nome do usúario em uma variavel 
            $_COOKIE['nome'] = $name; // Pegando a variavel e enviando para outro script via SESSION 

            if ($msg == "sucess_login") {//Se a mensagem for de sucesso, entrará no if
                include 'includes/modal.php'; //incluindo o modal para a página
            }
        }
    ?>
</body>

</html>