<?php
//Iniciando sessão
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['email']) == true){
    //Logou, então continua com as validações
    $ong_id = $_SESSION['id'];
    
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
    <link rel="stylesheet" href="css_dashboard/report.css">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="plugins/datatable/jquery.dataTables.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Companheiro Fiel - Reports</title>
    <script src="js/visualizacao.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo"></script>
</head>
<body>
    <div class="flex-dashboard">
        <?php include "includes/sidebar.php"; ?>

        <main>
            <?php include "includes/header.php"; ?>
            <div class="main-content">
                <h4 class="text-center">Seus reports</h4>
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
                        $sql = $mysql->prepare("SELECT ar.*,
                                                       a.location_address, 
                                                       a.location_number,
                                                       a.location_district,
                                                       a.location_state,
                                                       a.location_cep FROM animal_report ar INNER JOIN address a ON (ar.address_id = a.id) 
                                                       WHERE NOT( report_situation = 'rescued' OR report_situation = 'not_found') AND ong_id = ?;");
                        $sql->execute([$ong_id]);

                        //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                        while($linha = $sql->fetch(PDO::FETCH_ASSOC)){ //Resultado da pesquisa impressos linha por linha do contéudo
                            // Localização
                            $localizacao = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";
                           
                            //Colocando o resultado da linha em uma variavel
                            $animal = $linha['animal_type'];

                            //mudando a variavel para português
                            if($animal == "dog"){
                                $animal = "Cachorro";
                            }else if($animal == "cat"){
                                $animal = "Gato";
                            }else if($animal == "others"){
                                $animal  = "Outro";
                            }

                            echo '<tr>'; 
                                echo '<td>' .  $animal . '</td>';
                                echo '<td>' .  $linha['animal_description'] . '</td>';
                                echo '<td>' .  $localizacao . '</td>';
                                echo '<td><a class="btn btn-secondary" href="visualizaReport.php?id=' . $linha['id'] . '" >Visualizar</a></td>';
                            echo '</tr>'; 
                        }    
                    ?>
                    </tbody>
                </table>
                        
                <br /><hr /><br /><hr/>
                <h4 class="text-center">Todos os reports</h4>
                <table id="table_idsnd" class="display">
                    <thead>
                        <tr>
                            <th>Animal</th>
                            <th>Descrição</th>
                            <th>Localização</th>
                            <th>Distância</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Fazendo conexão com o banco de dados
                        include '../connect.php';

                        //Pegando conteúdo do banco de dados e colocando na variavel
                        $sqlscd = $mysql->prepare("SELECT a.location_cep FROM ong o INNER JOIN address a ON (o.address_id = a.id) WHERE o.id = ?;");
                        $sqlscd->execute([$ong_id]);
                        while($linha = $sqlscd->fetch(PDO::FETCH_ASSOC)){
                            $cepOng = "$linha[location_cep]";
                        }

                        //Pegando conteúdo do banco de dados e colocando na variavel
                        $sqltrd = $mysql->prepare("SELECT ar.*, 
                                                          a.location_address, 
                                                          a.location_number,
                                                          a.location_district,
                                                          a.location_state,
                                                          a.location_cep
                                                           FROM animal_report ar INNER JOIN address a ON (ar.address_id = a.id) WHERE report_situation = 'pending';");
                        $sqltrd->execute();

                        //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                        while($linha = $sqltrd->fetch(PDO::FETCH_ASSOC)){ //Resultado da pesquisa impressos linha por linha do contéudo
                            // Localização
                            $id = $linha['id'];
                            $localizacao = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";
                            $cepReport = "$linha[location_cep]";
                            $idDistancia = "idDistancia_$id";
                            //Colocando o resultado da linha em uma variavel
                            $animal = $linha['animal_type'];

                                                                    
                            //criando um array para colocar a distancia entre o report e a ong
                            // $get_distancia = echo "<script type='text/javascript'>apiDistanciaGoogle($idDistancia, '$cepOng', '$cepReport');</script>";
                            // echo $get_distancia;

                            // $distancia = Array(
                            //     'distancia' => $get_distancia
                            // );

                            // var_dump($distancia);

                            //mudando a variavel para português
                            if($animal == "dog"){
                                $animal = "Cachorro";
                            }else if($animal == "cat"){
                                $animal = "Gato";
                            }else if($animal == "others"){
                                $animal  = "Outro";
                            }

                            echo '<tr>'; 
                                echo '<td>' .  $animal . '</td>';
                                echo '<td>' .  $linha['animal_description'] . '</td>';
                                echo '<td>' .  $localizacao . '</td>';
                                echo '<td id="'. $idDistancia . '">' . '</td>'; 
                                echo '<td><a class="btn btn-secondary" href="visualizaReport.php?id=' . $linha['id'] . '" >Visualizar</a></td>';
                            echo '</tr>'; 

                            //Enviando a rua da ong e a rua do report para medir a distância 
                            echo "<script type='text/javascript'> 
                                    apiDistanciaGoogle($idDistancia, '$cepOng', '$cepReport');
                                  </script>";
                        }   
                    ?>
                    </tbody>
                </table>

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
    <script src="js/global.js"></script>
    <script src="js/SemUrl.js"></script>
    <script src="js/reports.js"></script>
</body>
</html>