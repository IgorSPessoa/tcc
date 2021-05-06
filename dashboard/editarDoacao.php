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
    <link rel="stylesheet" href="css_dashboard/adocoes.css">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
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
                <?php
                    // Conectando com o banco de dados
                    include '../connect.php';

                    // Declarando variáveis
                    $id = $_GET['id'];

                    // Pegando conteúdo do banco de dados e colocando na variavel
                    $sql = $mysql->prepare("SELECT * FROM animal_adoption WHERE id = $id");
                    $sql->execute();

                    // Verificando se o conteúdo dentro da variável é maior que 0
                    while($linha = $sql->fetch(PDO::FETCH_ASSOC)){ //Caso ele não esteja, será impresso linha por linha do contéudo
                        $name = $linha['name'];
                        $description =$linha['description'];
                        $img = $linha['img'];
                        $animal =$linha['type'];
                        $idade = $linha['age'];
                        $img = $linha['img'];
                    }    
                ?>
                <form action="controller/updateAdocao.php" method="POST" enctype="multipart/form-data" runat="server" novalidate> 
                    <div>
                        <h3 class="text-center" ><strong>Cadastrar adoção</strong><h3>
                        <div class="form-group">
                            <label for="name" class="mb-0"><h4>Nome:</h4></label>
                            <input class="form-control w-100" type="text" id="name" name="name" value='<?php echo $name; ?>' required>
                        </div>

                        <div class="form-group">
                            <label for="description" class="text-md"><h4>Descrição do Animal:</h4></label>
                            <input class="form-control w-100" id="description" name="description" value='<?php echo $description; ?>' required> 
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <label for="animal" class="text-md"><h4>Animal:</h4></label>
                                <input type="text" class="form-control" name="animal" id="animal" value='<?php echo $animal; ?>' required>
                            </div>

                            <div class="col">
                                <label for="idade" class="text-md"><h4>Idade:</h4></label>
                                <input type="text" class="form-control" name="age" id="age" value='<?php echo $idade; ?>' required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 container_images">
                                <h4>Foto do animal:<a id="imgInput" onclick="click_the_button(arquivo);" class="inputButton"><i id="upload" class="far fa-arrow-alt-circle-up"></i></a></h4>
                                <img src="<?php echo "../imgs/$img"; ?>" id="animalView">
                                <div class="mb-2">
                                    <input type="file" name="arquivo" id="arquivo" onchange="loadFile(event)" required/>
                                </div>
                            </div> 
                        </div>
                       
                        <div class="row">
                            <div class="col-sm">
                                <a class="btn btn-dark w-100 mb-2" type="button" href="adocoes.php">Voltar</a>
                            </div>

                            <div class="col-sm">
                                <input class="btn btn-warning text-light w-100 mb-2" type="reset" value="Apagar">
                            </div>

                            <div class="col-sm">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input class="btn btn-success w-100 mb-2" type="submit" value="Atualizar">
                            </div>
                        </div>
                    </div>
                </form>
            <?php include "includes/footer.php"; ?>
            </div>
        </main>
    </div>
    
    <script src="js/global.js"></script>
    <script src="js/upload.js"></script>
    <script src="plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/previewImg.js"></script>      
</body>
</html>