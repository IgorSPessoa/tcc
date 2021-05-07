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

//incluindo a conexão com o banco de dados 
include '../connect.php';

//Pegando o id da ong logada
$id = $_SESSION['id'];

//Pegando o nome da imagem cadastrada no banco de dados
$sql = $mysql->prepare("SELECT img FROM ong WHERE id = $id");
$sql->execute();

//Verificando se a linha de comnado retorna alguma resposta e coloca em uma variavel
while($linha = $sql->fetch(PDO::FETCH_ASSOC)){
    $img = $linha['img'];
}
                          
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css_dashboard/all.css">
    <link rel="stylesheet" href="css_dashboard/perfil.css">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Companheiro Fiel - Perfil</title>
</head>
<body>
    <div class="flex-dashboard">
        <?php include "includes/sidebar.php"; ?>

        <main>
            <?php include "includes/header.php"; ?>
            
            <div class="main-content">
                <h3 class="title">Perfil da ONG</h3>

                <form action="controller/atualizarPerfil.php" method="POST" enctype="multipart/form-data" >
                    <h4>Informações básicas</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="first">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Animal Feliz"> 
                            </div>     
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="first">E-mail</label>
                                <input type="email" class="form-control" id="name" name="name" placeholder="contato@animalfeliz.org">
                            </div>     
                        </div>                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Propósito</label>
                                <select class="form-control" id="reason">
                                    <option value="" selected disabled hidden>Selecione</option>
                                    <option value="acolher_animal">Acolher animais</option>
                                    <option value="socorro_animal">Socorro Animal</option>
                                    <option value="alimentacao_animal">Alimentação Animal</option>
                                    <option value="adocao_animal">Adoção Animal</option>
                                    <option value="outros">Outros</option>
                                </select>
                            </div>
                        </div>     
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="first">Data de abertura</label>
                                <input type="date" class="form-control" id="opening_date" name="opening_date">
                            </div>     
                        </div>                           
                    </div>
                    <div class="row">      
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first">Horário de funcionamento</label>
                                <input type="text" class="form-control" id="opening_hours" name="opening_hours" placeholder="Das 8hrs as 20hrs, de segunda-feira a sexta-feira">
                            </div>     
                        </div>   
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="first">Telefone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="(00) 994054654">
                            </div>     
                        </div>   
                    </div>
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Descrição da ONG</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Uma descrição básica sobre sua ONG"></textarea>
                            </div>   
                        </div>                                
                    </div>

                    <h4>Localização</h4>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="first">Cep</label>
                                <input type="text" class="form-control" id="cep" name="cep" placeholder="01001000">
                            </div>     
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first">Endereço</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Rua são paulo">
                            </div>     
                        </div> 
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="first">Nº</label>
                                <input type="text" class="form-control" id="number" name="number" placeholder="14">
                            </div>     
                        </div>       
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="first">Bairro</label>
                                <input type="text" class="form-control" id="district" name="district" placeholder="Bonfim">
                            </div>     
                        </div>     
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="first">Estado</label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="São Paulo">
                            </div>     
                        </div>                                  
                    </div>
                    <h4>Imagem</h4>
                    <div class="row">
                        <div class="col-md-6 container_images">
                            <h6>Logo <a onclick="clickInput('logo_input');" class="inputButton"><i class="fas fa-cogs"></i></a></h6>
                            <img src="../imgs/<?php echo $img;?>" class="img-thumbnail" id="logo_upload">
                            <div class="custom-file">
                                <input type="file" name ="file" id="logo_input" onchange="loadFile(event)" accept="image/png, image/jpeg" required/>
                            </div>
                        </div> 
                    </div>

                    <input type="submit" class="btn btn-primary" value="Atualizar dados">
                </form>
                <?php include "includes/footer.php"; ?>
            </div>
        </main>
    </div>

    <script src="js/global.js"></script>
    <script src="js/perfil.js"></script>
    <script src="plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/previewLogo.js"></script>    
</body>
</html>