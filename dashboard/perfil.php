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
$sql = $mysql->prepare("SELECT * FROM ong WHERE id = $id");
$sql->execute();

//Verificando se a linha de comnado retorna alguma resposta e coloca em uma variavel
while($linha = $sql->fetch(PDO::FETCH_ASSOC)){
    $nome = $linha['ong_name'];
    $email = $linha['ong_email'];
    $proposito = $linha['ong_purpose'];
    $dataAbertura = $linha['ong_opening_date'];
    $horarioFunc = $linha['ong_business_hours'];
    $telefone = $linha['ong_phone'];
    $descricao = $linha['ong_description'];
    $CEP = $linha['location_cep'];
    $location = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";
    $rua = $linha['location_address'];
    $numero = $linha['location_number'];
    $bairo = $linha['location_district'];
    $estado = $linha['location_state'];
    $img = $linha['ong_img'];
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
    <link rel="stylesheet" href="css_dashboard/maps.css">
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
                                <label for="name">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $nome;?>" readonly> 
                            </div>     
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email;?>" readonly>
                            </div>     
                        </div>                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reason">Propósito</label>
                                <select class="form-control" id="reason" name="reason" required>
                                    <option value="" selected disabled hidden>Selecione</option>
                                    <option value="acolher_animal" <?php if($proposito == "acolher_animal") { echo "selected";} ?>>Acolher animais</option>
                                    <option value="socorro_animal" <?php if($proposito == "socorro_animal") { echo "selected";} ?>>Socorro Animal</option>
                                    <option value="alimentacao_animal" <?php if($proposito == "alimentacao_animal") { echo "selected";} ?>>Alimentação Animal</option>
                                    <option value="adocao_animal" <?php if($proposito == "adocao_animal") { echo "selected";} ?>>Adoção Animal</option>
                                    <option value="outros" <?php if($proposito == "outros") { echo "selected";} ?>>Outros</option>
                                </select>
                            </div>
                        </div>                              
                    </div>
                    <div class="row">      
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="opening_hours">Horário de funcionamento</label>
                                <input type="text" class="form-control" id="opening_hours" name="opening_hours" value="<?php echo $horarioFunc;?>" required>
                            </div>     
                        </div>   
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="phone">Telefone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $telefone;?>" required>
                            </div>     
                        </div>   
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="opening_date">Data de abertura</label>
                                <input type="date" class="form-control" id="opening_date" name="opening_date" value="<?php echo $dataAbertura;?>" readonly>
                            </div>     
                        </div>  
                    </div>
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Descrição da ONG</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Uma descrição básica sobre sua ONG" required><?php echo $descricao;?></textarea>
                            </div>   
                        </div>                                
                    </div>

                    <h4>Localização</h4>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="CEP">Cep</label>
                                <input type="text" class="form-control" id="cep" name="cep" value="<?php echo $CEP;?>" onblur="pesquisacep(this.value);" required>
                            </div>     
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Endereço</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $rua;?>" required>
                            </div>     
                        </div> 
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="number">Nº</label>
                                <input type="text" class="form-control" id="number" name="number" value="<?php echo $numero;?>" required>
                            </div>     
                        </div> 
                    </div>

                    <div class="row">      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="district">Bairro</label>
                                <input type="text" class="form-control" id="district" name="district"value="<?php echo $bairo;?>" required>
                            </div>     
                        </div>     
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="state">Estado</label>
                                <input type="text" class="form-control" id="state" name="state" value="<?php echo $estado;?>" required>
                            </div>     
                        </div>                                  
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group" id="container_map">
                                <label for="map" class="m-0">Maps</label>
                                <div class="w-100 shadow border border-dark rounded" id="map"></div>
                            </div>     
                        </div>
                    </div>

                    <h4>Imagem</h4>
                    <div class="row">
                        <div class="col-md-6 container_images">
                            <h6>Logo <a onclick="clickInput('logo_input');" class="inputButton"><i class="fas fa-cogs"></i></a></h6>
                            <img src="../imgs/<?php echo $img;?>" class="img-thumbnail" id="logo_upload">
                            <div class="custom-file">
                                <input type="file" name ="arquivo" id="logo_input" onchange="loadFile(event)" accept="image/png, image/jpeg"/>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo"></script>
    <script type="text/javascript">var address = "<?= $location ?>";</script>
    <script src="js/viacep.js"></script>
    <script src="js/previewLogo.js"></script>   
    <script src="js/validCep.js"></script>
    <script src="js/maps.js"></script>
</body>
</html>
