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
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    //verificando se tem um email por SESSION
    if(isset($_SESSION['email']) == true){
        //Logou, então o nav vai ser incluido
        require_once("includes/nav.php");
    }else{//Não logou então volta para a página inicial
    unset($_SESSION['email']);
    unset($_SESSION['acc_type']);
        if(session_status() !== PHP_SESSION_ACTIVE){
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
</body>

</html>