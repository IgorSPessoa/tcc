<?php
//Iniciando sessão
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['email']) == true){
    //Logou, então continua com as validações

}else{//Não logou então volta para a página inicial
    if(session_status() !== PHP_SESSION_ACTIVE){
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
    <link rel="stylesheet" href="css_dashboard/dashboard.css">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Companheiro Fiel</title>
</head>
<body>
    <div class="flex-dashboard">
        <?php include "includes/sidebar.php"; ?>

        <main>
            <?php include "includes/header.php"; ?>
            
            <div class="main-content">
                <h3 class="title">Dashboard</h3>
                
                <div class="container-info">
                    <div class="info">
                        <i class="fas fa-dog"></i>
                        <div>
                            <h1>15</h1>
                            <span>Animais resgatados</span>         
                        </div>
                    </div>
                    <div class="info">
                        <i class="fas fa-home"></i>
                        <div>
                            <h1>19</h1>
                            <span>Animais adotados</span>         
                        </div>
                    </div>
                    <div class="info">
                        <i class="fas fa-medkit"></i>
                        <div>
                            <h1>6</h1> 
                            <span>Em andamento</span>         
                        </div>
                    </div>
                    <div class="info">
                        <i class="fas fa-eye"></i>
                        <div>
                            <h1>1064</h1>
                            <span>Visualizações</span>         
                        </div>
                    </div>
                </div>

                <div class="container-table">
                    <div class="card">
                        <div class="card-header">
                            <b>Reports</b> <i class="fas fa-arrow-right"></i> <a href="reports.php"><i class="fas fa-exclamation-circle"></i><a>
                        </div>
                        <div class="card-body"> 
                            <table class="table_fast">
                                <tr>
                                    <th>Nome</th>
                                    <th>Situação</th>
                                    <th>Ações</th>
                                </tr>
                                <tr>
                                    <td>Alface</td>
                                    <td>⏱️ Aguardando</td>
                                    <td>
                                        <a href="#">Verificar</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alface</td>
                                    <td>📅 Agendado</td>
                                    <td>
                                        <a href="#">Verificar</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alface</td>
                                    <td>✔️ Adotado</td>
                                    <td>
                                        <a href="#">Verificar</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alface</td>
                                    <td>✔️ Adotado</td>
                                    <td>
                                        <a href="#">Verificar</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <b>Adoções</b> <i class="fas fa-arrow-right"></i> <a href="adocoes.php"><i class="fas fa-cat"></i></a>
                        </div>
                        <div class="card-body">
                            <table class="table_fast">
                                <tr>
                                    <th>Nome</th>
                                    <th>Situação</th>
                                    <th>Ações</th>
                                </tr>
                                <tr>
                                    <td>Alface</td>
                                    <td>⏱️ Aguardando</td>
                                    <td>
                                        <a href="#">Verificar</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alface</td>
                                    <td>📅 Agendado</td>
                                    <td>
                                        <a href="#">Verificar</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alface</td>
                                    <td>✔️ Adotado</td>
                                    <td>
                                        <a href="#">Verificar</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alface</td>
                                    <td>✔️ Adotado</td>
                                    <td>
                                        <a href="#">Verificar</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>     

                </div>
                
                <?php include "includes/footer.php"; ?>
            </div>
        </main>
    </div>

    <script src="js/global.js"></script>
    <script src="plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>
</body>
</html>