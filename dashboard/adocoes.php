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
    <title>Companheiro Fiel - Adoções</title>
</head>
<body>
    <div class="flex-dashboard">
        <!-- Includindo a barra lateral -->
        <?php include "includes/sidebar.php"; ?>

        <main>
        <!-- Incluindo o cabeçalho do site -->
            <?php include "includes/header.php"; ?>
            
            <div class="main-content">
                <div class="d-flex flex-row-reverse">
                    <a class=" btn btn-info" href='novaAdocao.php'>Nova adoção</a>
                </div>
                <br />
                <!-- Criando a tabela através do plug-in DataTables -->
                <table id="table_id" class="display">
                    <thead>
                        <tr>
                            <th>Nome</th> 
                            <th>Descrição</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        //Incluindo a conexão com o banco de dados
                        include '../connect.php';

                        // Pegando conteúdo do banco de dados e colocando na variavel
                        $sql = $mysql->prepare("SELECT * FROM animal_adoption");
                        $sql->execute();

                        // Verificando se o conteúdo dentro da variável é maior que 0
                        while($linha = $sql->fetch(PDO::FETCH_ASSOC)){ //Caso ele não esteja, será impresso linha por linha do contéudo
                            $id = $linha['id'];

                            echo '<tr>'; 
                                echo '<td>' .  $linha['name'] . '</td>';
                                echo '<td>' .  $linha['description'] . '</td>';
                                echo '<td><a class="btn btn-secondary" href="editarDoacao.php?id=' . $id . '" >Editar</a></td>';
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
    <script src="js/adocoes.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>
    <script src="plugins/datatable/jquery.dataTables.js"></script>
</body>
</html>