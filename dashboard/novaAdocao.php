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
                <form method="POST" action="controller/salvarNovaAdocao.php" enctype="multipart/form-data" runat="server">
                    <div>
                        <h3 class="text-center"><strong>Cadastrar adoção</strong></h3>
                        <div class="form-group">
                            <label for="name" class="mb-0"><h4>Nome:</h4></label>
                            <input class="form-control w-100" type="text" id="animal_name" name="animal_name" placeholder="Ex: Bolinha" autocomplete="off" maxlength="50" required>
                        </div>

                        <div class="form-group"> 
                            <label for="description" class="text-md"><h4>Descrição do Animal:</h4></label>
                            <textarea class="form-control " id="animal_description" name="animal_description" rows="2" placeholder="Ex: Bolinha é um gatinho muito preguiçoso, que gosta de carinho e brincar com bolinhas de pelo"  maxlength="200" required></textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <label for="animal" class="text-md"><h4>Raça:</h4></label>
                                <input type="text" class="form-control" name="animal_race" id="animal_race" placeholder="Ex: Buldogue-campeiro" autocomplete="off" maxlength="50" required>
                            </div>

                            <div class="col">
                                <label for="age" class="text-md"><h4>Peso:</h4></label>
                                <input type="text" class="form-control" name="animal_weight" id="animal_weight" placeholder="Ex: 10.5kg" autocomplete="off" maxlength="50" required>
                            </div>

                            <div class="col">
                                <label for="age" class="text-md"><h4>Porte:</h4></label>
                                <select class="form-control" id="animal_category" name="animal_category">
                                    <option selected>Selecione...</option>
                                    <option value="small">Pequeno</option>
                                    <option value="average">Médio</option>
                                    <option value="big">Grande</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="age" class="text-md"><h4>Sexo</h4></label>
                                <select class="form-control" id="animal_gender" name="animal_gender">
                                    <option selected>Selecione...</option>
                                    <option value="male">Macho</option>
                                    <option value="female">Fêmea </option>
                                </select>                            
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <label for="animal" class="text-md"><h4>Animal:</h4></label>
                                <select class="form-control" id="animal_type" name="animal_type">
                                    <option selected>Selecione...</option>
                                    <option value="dog">Cachorro</option>
                                    <option value="cat">Gato</option>
                                    <option value="others">Outros</option>
                                </select>                           
                             </div>

                            <div class="col">
                                <label for="age" class="text-md"><h4>Idade:</h4></label>
                                <input type="text" class="form-control" name="animal_age" id="animal_age" placeholder="Ex: 1 ano e 2 meses" autocomplete="off" maxlength="30">
                                <small>Não obrigatório</small>
                            </div>

                            <div class="col">
                                <label for="age" class="text-md"><h4>Na Ong Desde:</h4></label>
                                <input type="date" class="form-control" name="animal_ong_since" id="animal_ong_since" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 container_images">
                                <h4>Foto do animal:<a id="imgInput" onclick="click_the_button(arquivo);" class="inputButton"><i id="upload" class="far fa-arrow-alt-circle-up"></i></a></h4>
                                <img src="../imgsUpdate/preview.jpg" id="animalView">
                                <div class="mb-2">
                                    <input type="file" name="arquivo" id="arquivo"  onchange="loadFile(event)" accept="image/png, image/jpeg" required/>
                                </div>
                            </div> 
                        </div>


                        <div class="row">
                            <div class="col-sm">
                                <a class="btn btn-dark w-100 mb-2" type="button" href="adocoes.php">Voltar</a>
                            </div>
                        
                            <div class="col-sm">
                                <input class="btn btn-warning text-light w-100 mb-2" type="reset" value="Resetar">
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
    <script src="js/SemUrl.js"></script>
    <script src="plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/novaAdocao.js"></script> 
    <?php 
    //Verificar se existe uma mensagem para abrir um modal
    if(isset($_GET['msg'])) { //Verificando se existe mensagem
        
        $msg = $_GET['msg']; //pegando a mensagem
        $_COOKIE['msg'] = $msg; //Transformando-a em cookie para enviar para outro script

        if ($msg == "invalid_size_animal"){//verificando se a msg deu 'tamanho inválido do animal' 
            $tamanho = $_GET['size'];
            $_COOKIE['size'] = $tamanho;
        }
        include '../includes/modal.php'; //incluindo o modal para a página
    }
    ?>
</body>
</html>