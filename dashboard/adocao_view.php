<?php 
session_start();

if(!isset($_SESSION['id']) || $_SESSION['acc_type'] != "ong"){
    header("Location: ../login.php?msg=need_login");
    die("Login needed!");
}


include "../connect.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    die("Id obrigatorio!");
}


$dados = $mysql->query("SELECT * FROM animal_adoption WHERE id = $id;"); 
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
                        <h2>Adoção</h2>
                        <p>Verifique informações da adoção aqui</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" onclick="window.location='adocao.php';" id="back_button"> Voltar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Sobre o animal</h5>    
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="first">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $linha['name'];?>" readonly>
                        </div>                 
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="first">Descrição</label>
                            <input type="text" class="form-control" id="description" name="description" value="<?php echo $linha['description'];?>" readonly>
                        </div>       
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first">Imagem do animal</label><br>
                            <img src="../imgs/<?php echo $linha['img'];?>" alt="" id="img_lock" name="first">
                        </div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5>Informações da adoção</h5>    
                    </div>
                
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first">Situação</label>
                            <select class="form-control" aria-label="Default select example">
                                <option value="1"><i class="fas fa-clock"></i> Aguardando adoção</option>
                                <option value="2"><i class="far fa-pause-circle"></i> Animal reservado</option>
                                <option value="3"><i class="fas fa-check-circle"></i> Animal adotado</option>
                            </select>                        
                        </div>
                    </div>
                        <div class="col-md-12">
                        
                        <button type="button" class="btn btn-primary">Atualizar</button>
                    </div>
                </div>
            </div>

            </form>
            <br>
        </div>

    </main>
</body>
</html>