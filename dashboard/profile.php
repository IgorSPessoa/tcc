<?php 
session_start();

if(!isset($_SESSION['id']) || $_SESSION['acc_type'] != "ong"){
    header("Location: ../login.php?msg=need_login");
    die("Login needed!");
}

include "../connect.php";

$ong_id = $_SESSION['id'];
$dados = $mysql->query("SELECT * FROM ong WHERE id = $ong_id;"); 
$linha = mysqli_fetch_array($dados);

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Panel</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/reports.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
</head>
<body>
    <?php include "include/sidenav.php"; ?>
    <main>
        <div class="container_form">
            <form>
                <div class="container_title">
                    <div>
                        <h2>Perfil da ONG</h2>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" onclick="window.location='adocao.php';" id="back_button"> Voltar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Sobre</h5>    
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="first">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $linha['name']; ?>">
                        </div>                 
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="first">Descrição</label>
                            <input type="text" class="form-control" id="description" name="description" value="<?php echo $linha['description']; ?>">
                        </div>       
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="first">Endereço</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $linha['address']; ?>">
                        </div>       
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="first">Cep</label>
                            <input type="text" class="form-control" id="address_cep" name="address_cep" value="<?php echo $linha['address_cep']; ?>">
                        </div>       
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first">Imagem da ong</label><br>
                            <img src="../imgs/ong01.jpg" alt="" style="width: 250px;">
                            <input type="file" name="animal_img" id="animal_img">
                        </div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5>Informações</h5>    
                    </div>
                
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>Animais restados: 15</p>                 
                            <p>Animais adotados: 27</p>                 
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input type="submit" value="Atualizar" class="btn btn-success" disabled>
                    </div>
                </div>
            </div>

            </form>
            <br>
        </div>

    </main>
</body>
</html>