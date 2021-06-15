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
                            <?php
                            // Fazendo conexão com o banco de dados
                            include '../connect.php';

                            //Pegando o id da ong
                            $idOng = $_SESSION['id'];

                            // Pegando conteúdo do banco de dados e colocando na variavel
                            $sql = $mysql->prepare("SELECT count(report_situation) FROM animal_report WHERE report_situation = 'rescued' AND ong_id = $idOng;");
                            $sql->execute();    
                            
                            //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                            while($linha = $sql->fetch(PDO::FETCH_BOTH)){ //Resultado da pesquisa impressos linha por linha do contéudo  
                                $count = $linha[0];
                            }

                            echo '<h1> ' . $count . '</h1>';
                            ?>
                            <span>Animais resgatados</span>         
                        </div>
                    </div>
                    <div class="info">
                        <i class="fas fa-home"></i>
                        <div>
                            <?php
                            // Fazendo conexão com o banco de dados
                            include '../connect.php';

                            // Pegando conteúdo do banco de dados e colocando na variavel
                            $sql = $mysql->prepare("SELECT count(adoption_situation) FROM animal_adoption WHERE adoption_situation = 'adopted' AND ong_id = $idOng;");
                            $sql->execute();    
                            
                            //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                            while($linha = $sql->fetch(PDO::FETCH_BOTH)){ //Resultado da pesquisa impressos linha por linha do contéudo  
                                $count = $linha[0];
                            }

                            echo '<h1> ' . $count . '</h1>';
                            ?>
                            <span>Animais adotados</span>         
                        </div>
                    </div>
                    <div class="info">
                        <i class="fas fa-medkit"></i>
                        <div>
                            <?php
                            // Fazendo conexão com o banco de dados
                            include '../connect.php';

                            // Pegando conteúdo do banco de dados e colocando na variavel
                            $sql = $mysql->prepare("SELECT count(report_situation) FROM animal_report WHERE report_situation = 'scheduled' AND ong_id = $idOng;");
                            $sql->execute();    
                            
                            //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                            while($linha = $sql->fetch(PDO::FETCH_BOTH)){ //Resultado da pesquisa impressos linha por linha do contéudo  
                                $count = $linha[0];
                            }

                            echo '<h1> ' . $count . '</h1>';
                            ?>
                            <span>Em andamento</span>         
                        </div>
                    </div>
                    <div class="info">
                        <i class="fas fa-eye"></i>
                        <div>
                            <?php
                            // Fazendo conexão com o banco de dados
                            include '../connect.php';

                            // Pegando conteúdo do banco de dados e colocando na variavel
                            $sql = $mysql->prepare("SELECT ong_view FROM ong WHERE id = $idOng;");
                            $sql->execute();    
                            
                            //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                            while($linha = $sql->fetch(PDO::FETCH_ASSOC)){ //Resultado da pesquisa impressos linha por linha do contéudo  
                                $count = $linha['ong_view'];
                            }

                            echo '<h1> ' . $count . '</h1>';
                            ?>
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
                                <?php
                                    // Fazendo conexão com o banco de dados
                                    include '../connect.php';

                                    //Pegando conteúdo do banco de dados e colocando na variavel
                                    $sql = $mysql->prepare("SELECT id, animal_type, report_situation FROM animal_report WHERE NOT (report_situation = 'rescued' OR report_situation = 'not_found') AND ong_id = $idOng LIMIT 8;");
                                    $sql->execute();
                                    //contando retorno do banco de dados
                                    $count = $sql->rowCount();
                                    //testando se teve arquivos retornados do banco de dados se sim mostra os resultados
                                    if($count>=1){
                                        //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                                        while($linha = $sql->fetch(PDO::FETCH_ASSOC)){ //Resultado da pesquisa impressos linha por linha do contéudo  
                                            //Colocando o resultado da linha em uma variavel
                                            $situacao = $linha['report_situation'];
                                            $animal = $linha['animal_type'];

                                            //mudando a variavel para português
                                            if($situacao == "pending"){
                                                $situacao = "pendente";
                                            }else if($situacao == "waiting"){
                                                $situacao = "aguardando";
                                            }else if($situacao == "scheduled"){
                                                $situacao = "agendado";
                                            }else if($situacao == "not_found"){
                                                $situacao = "Não localizado";
                                            }else if($situacao == "rescued"){
                                                $situacao = "resgatado";
                                            }

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
                                                echo '<td>' .  $situacao . '</td>';
                                                echo '<td><a href="visualizaReport.php?id=' . $linha['id'] . '" >Visualizar</a></td>';
                                            echo '</tr>'; 
                                        }//se não, imprime a informação de que não tem reportes
                                    }else{
                                        echo '<tr>'; 
                                        echo '<td></td>';
                                        echo'<td>Nenhum Reporte disponível!</td>';
                                        echo '<td></td>';
                                        echo '</tr>'; 
                                    }
                                ?>
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
                                <?php
                                    //Incluindo a conexão com o banco de dados
                                    include '../connect.php';

                                    // Pegando conteúdo do banco de dados e colocando na variavel
                                    $sql = $mysql->prepare("SELECT * FROM animal_adoption WHERE NOT adoption_situation = 'adopted' AND ong_id = $idOng LIMIT 8;");
                                    $sql->execute();
                                    //contando retorno do banco de dados
                                    $count = $sql->rowCount();
                                    //testando se teve arquivos retornados do banco de dados se sim mostra os resultados
                                    if($count>=1){
                                    // Verificando se o conteúdo dentro da variável é maior que 0
                                        while($linha = $sql->fetch(PDO::FETCH_ASSOC)){ //Caso ele não esteja, será impresso linha por linha do contéudo
                                            //Colocando o resultado da linha em uma variavel
                                            $situacao = $linha['adoption_situation'];

                                            //mudando a variavel para português
                                            if($situacao == "waiting"){
                                                $situacao = "aguardando";
                                            }else if($situacao == "scheduled"){
                                                $situacao = "agendado";
                                            }

                                            //colocando o id para conseguir acessar o visualizar
                                            $id = $linha['id'];
                                            echo '<tr>'; 
                                                echo '<td>' .  $linha['animal_name'] . '</td>';
                                                echo '<td>' .  $situacao . '</td>';
                                                echo '<td><a href="editarAdoacao.php?id=' . $id . '" >Vizualizar</a></td>';
                                            echo '</tr>';
                                        }//se não, imprime a informação de que não tem reportes
                                    }else{
                                        echo '<tr>'; 
                                        echo '<td></td>';
                                        echo'<td>Nenhum animal para adoção!</td>';
                                        echo '<td></td>';
                                        echo '</tr>'; 
                                    }
                                ?>
                            </table>
                        </div>
                    </div>     

                </div>
                
                <?php 
                //incluindo o footer da página
                include "includes/footer.php"; 
                ?>
            </div>
        </main>
    </div>

    <script src="js/global.js"></script>
    <script src="js/SemUrl.js"></script>
    <script src="plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>
    <?php
    //verificando se existe uma mensagem para o usúario
        if(isset($_GET['msg'])) {
            
            $msg = $_GET['msg']; // colocando a mensagem em uma variavel
            $_COOKIE['msg'] = $msg; // Colocando a variavel em um cookie, para conseguir pegar no outro script
            
            $name = "Ong " . $_SESSION['name']; //Colocando o nome da ong em uma variavel
            $_COOKIE['nome'] = $name; //Mandando o nome da variável por cookie para outro script

            include '../includes/modal.php'; //incluindo o modal para a página
        }
    ?>
</body>
</html>