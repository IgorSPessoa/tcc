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
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Companheiro Fiel</title>
</head>
<body>
    <div class="flex-dashboard">
        <!-- Includindo a barra lateral -->
        <?php include "includes/sidebar.php"; ?>

        <main>
            <!-- Incluindo o cabeçalho do site -->
            <?php include "includes/header.php"; ?>

            <div class="main-content">

                <?php
                    // conectando com o banco de dados
                    include '../connect.php';

                    //declarando variáveis
                    $id = $_GET['id'];
                    
                   // Pegando conteúdo do banco de dados e colocando na variavel
                   $sql = $mysql->prepare("SELECT * FROM tcc.animal_report WHERE id = $id");
                   $sql->execute();

                   //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                   while($linha = $sql->fetch(PDO::FETCH_ASSOC)){ //Caso ele não esteja, será impresso linha por linha do contéudo
                        $author = $linha['author_name'];
                        $phone = $linha['author_phone'];
                        $animal = $linha['animal_description']; 
                        $description = $linha['animal_situation'];
                        $location =  $linha['localization_lastview']; 
                        $pointOfReference = $linha['localization_observation']; 
                        $imgAnimal = $linha['animal_photo'];
                        $imgLocation = $linha['localization_photo'];
                    }    
                ?> 
                <div class="row">    
                    <div class="col">
                        <h3 class="text-center"><strong>Visualização do Reporte</strong></h3>
                    </div>
                </div>

                <div class="d-flex flex-row-reverse">
                    <a class="btn btn-dark" type="button" href="reports.php">Voltar</a>
                </div>

                <form>
                    <!-- divs para colocar o autor, telefone e o animal em linhas até 576px -->
                    <div class="row">
                        <div class="col-sm">
                            <label for="author_name" class="m-0"><h4>Autor</h4></label>
                            <input class="form-control w-100 mb-2" type="text" id="author_name" name="author_name" value='<?php echo $author?>' readonly>
                        </div>

                        <div class="col-sm">
                            <label for="author_phone" class="m-0"><h4>Telefone</h4></label>
                            <input class="form-control w-100 mb-2" type="text" id="author_phone" name="author_phone" value='<?php echo $phone?>' readonly> 
                        </div>

                        <div class="col-sm">
                            <label for="animal_description" class="m-0"><h4>Animal</h4></label>
                            <input class="form-control w-100 mb-2" type="text"  id="animal_description" name="animal_description" value='<?php echo $animal?>' readonly>
                        </div>
                    
                    </div>

                    <div class="form-group">
                        <label for="description" class="text-md"><h4>Descrição</h4></label>
                        <input class="form-control w-100 mb-2" type="text" id="description" name="description" value='<?php echo $description?>' readonly>
                    </div>
                    
                    <!-- divs para colocar a localização e o ponto de referência em linha até 576px -->
                    <div class="row">
                        <div class="col-sm">
                            <label for="localization_lastview" class="m-0"><h4>Localização</h4></label>
                            <input class="form-control w-100 mb-2" type="text" id="localization_lastview" name="localization_lastview" value='<?php echo $location?>' readonly>
                        </div>

                        <div class="col-sm">
                            <label for="localization_observation" class="m-0"><h4>Ponto de referência</h4></label>
                            <input class="form-control w-100 mb-2" type="text" id="localization_observation" name="localization_observation" value='<?php echo $pointOfReference?>' readonly> 
                        </div>
                    
                    </div>

                    <!-- divs para colocar as imagens em linhas até 576px -->
                    <div class="row">

                        <div class="col-sm">
                            <h4 class="m-0">Foto animal</h4>
                            <img class="w-100 shadow border border-dark rounded " src="../imgs/<?php echo $imgAnimal?>">
                        </div>

                        <div class="col-sm">
                            <h4 class="m-0">Foto do local</h4>
                            <img class="w-100 shadow border border-dark rounded" src="../imgs/<?php echo $imgLocation?>">
                        </div>

                        
                        <div class="col-sm">
                            <h4 class="m-0">Maps</h4>
                            <img class="w-100 shadow border border-dark rounded" src="images/maps.jpg">
                        </div>

                    </div>
                </form>
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