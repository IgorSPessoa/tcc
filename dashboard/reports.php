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
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="plugins/datatable/jquery.dataTables.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Companheiro Fiel - Reports</title>
</head>
<body>
    <div class="flex-dashboard">
        <?php include "includes/sidebar.php"; ?>

        <main>
            <?php include "includes/header.php"; ?>
            
            <div class="main-content">
                <table id="table_id" class="display">
                    <thead>
                        <tr>
                            <th>Animal</th>
                            <th>Descrição</th>
                            <th>Localização</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Fazendo conexão com o banco de dados
                        include '../connect.php';

                        // Pegando conteúdo do banco de dados e colocando na variavel
                        $sql = $mysql->prepare("SELECT * FROM animal_report");
                        $sql->execute();

                        //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                        while($linha = $sql->fetch(PDO::FETCH_ASSOC)){ //Resultado da pesquisa impressos linha por linha do contéudo
                            echo '<tr>'; 
                                echo '<td>' .  $animal = $linha['animal_type'] . '</td>';
                                echo '<td>' .  $description = $linha['animal_description'] . '</td>';
                                echo '<td>' .  $localizacao = $linha['localization_lastview'] . '</td>';
                                echo '<td><a class="btn btn-secondary" href="visualizaReport.php?id=' . $linha['id'] . '" >Visualizar</a></td>';
                            echo '</tr>';
                        }    
                        ?>
                    </tbody>
                </table>

                <?php include "includes/footer.php"; ?>
            </div>
        </main>
    </div>

    <script src="js/global.js"></script>                   
    <script src="plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="js/reports.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>
    <script src="plugins/datatable/jquery.dataTables.js"></script>
</body>
</html>