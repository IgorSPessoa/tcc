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
                <!-- Formulário de adoção -->
                <form action="controller/salvarNovaAdocao.php" enctype="multipart/form-data" runat="server" method="POST">
                    <div>
                        <h3 class="text-center" ><strong>Cadastrar adoção</strong></h3>
                        <div class="form-group">
                            <label for="name" class="mb-0"><h4>Nome:</h4></label>
                            <input class="form-control w-100" type="text" id="name" name="name" placeholder="Ex: Bolinha"required>
                        </div>

                        <div class="form-group"> 
                            <label for="description" class="text-md"><h4>Descrição do Animal:</h4></label>
                            <input class="form-control w-100" id="description" name="description" placeholder="Ex: Bolinha é um gatinho muito preguiçoso, que gosta de carinho e brincar com bolinhas de pelo" required> 
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <label for="animal" class="text-md"><h4>Animal:</h4></label>
                                <input type="text" class="form-control" name="animal" id="animal" placeholder="Ex: Gato" required>
                            </div>

                            <div class="col">
                                <label for="age" class="text-md"><h4>Idade:</h4></label>
                                <input type="text" class="form-control" name="age" id="age" placeholder="Ex: 9 meses" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 container_images">
                                <h4>Foto do animal:<a id="imgInput" onclick="click_the_button(arquivo);" class="inputButton"><i id="upload" class="far fa-arrow-alt-circle-up"></i></a></h4>
                                <img id="animalView">
                                <div class="mb-2">
                                    <input type="file" name="arquivo" id="arquivo"  onchange="loadFile(event)" required/>
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
                                <input class="btn btn-success w-100 mb-2" type="submit" value="Salvar">
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