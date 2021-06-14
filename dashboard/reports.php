<?php
//Iniciando sessão
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (isset($_SESSION['email']) == true) {
    //Logou, então continua com as validações
    $ong_id = $_SESSION['id'];
    setcookie('id', $ong_id);
} else { //Não logou então volta para a página inicial
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    session_unset();
    session_destroy();
    require_once("logout.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css_dashboard/all.css">
    <link rel="stylesheet" href="css_dashboard/report.css">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="plugins/datatable/jquery.dataTables.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Companheiro Fiel - Reports</title>
</head>

<body>
    <div class="flex-dashboard">
        <?php include "includes/sidebar.php"; ?>
        <main>
            <?php include "includes/header.php"; ?>
            <div class="main-content">
                <hr />
                <h4 class="text-center">Seus reports
                    <div class="spinner-border" role="status" id="loadingYour">
                        <span class="sr-only">Loading...</span>
                    </div>
                </h4>

                <div class="content">
                    <table id="YourReports" class="display" width="100%"></table>
                </div>

                <br />
                <hr />
                <h4 class="text-center">Todos os reports
                    <div class="spinner-border" role="status" id="loadingAll">
                        <span class="sr-only">Loading...</span>
                    </div>
                </h4>

                <div class="content">
                    <table id="AllReports" class="display" width="100%"></table>
                </div>

                <?php
                //incluindo o footer na página
                include "includes/footer.php";
                ?>
            </div>
        </main>
    </div>

    <script src='plugins/jquery/jquery-3.6.0.min.js'></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>
    <script src="plugins/datatable/jquery.dataTables.js"></script>
    <script src="js/createTable.js"></script>
    <script src="js/global.js"></script>
    <script src="js/SemUrl.js"></script>
    <?php
    //verificando se existe uma mensagem na URL da página
    if (isset($_GET['msg'])) {//Se existe ele cairá neste if, se não, continuará a operação normalmente
        $msg = $_GET['msg'];// Colocando a mensagem em uma variável
        $_COOKIE['msg'] = $msg; // Colocando ela em cookie para conseguir pegar em outro script 
    }
    include '../includes/modal.php'; //incluindo o modal para a página
    ?>
</body>

</html>