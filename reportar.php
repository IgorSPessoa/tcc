<?php
//Iniciando sessão
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (isset($_SESSION['email']) == true) {
    //Logou, então continua com as valida;'oes
    require_once("includes/nav.php");
} else { //Não logou então volta para a página inicial
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    session_unset();
    session_destroy();
    require_once("includes/nav.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!--Requisitos de tags meta-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--ico-->
    <link rel="shortcut icon" type="image" href="./imgs/CF.ico">

    <!--Css-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/resetcss.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/report.css">
    <link rel="stylesheet" href="dashboard/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboard/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/responsiveToBoot.css">
    <title>Reportar</title>
</head>

<body>
    <main class="p-3">
        <div class="text-center">
            <h1>Animal em perigo? Reporte aqui!</h1>
            <p>Nossas ONG cadastradas serão informadas sobre isto.</p>
            <br>
        </div>

        <?php if(isset($_SESSION['email']) != true){ echo '<center> Não está logado? <a href="login.php">Logue aqui</a>, Não tem uma conta? <a href="criar_conta.php">Crie aqui</a> </center>';} ?>
        <form class="bg-white shadow lg-3 border border-3 border-primary px-5 py-5" action="controller/emulator_animal_report.php" enctype="multipart/form-data" runat="server" method="POST">

            <div class="form-group">
                <h3>Sobre o animal</h3>
                <label for="situation">Qual é a situação do animal?</label>
                <?php if(isset($_SESSION['email']) == true){
                        echo '<input type="text" class="form-control" id="situacao_animal" name="situacao_animal" required>';
                    } else {
                        echo '<input type="text" class="form-control" id="situacao_animal" name="situacao_animal" disabled>';
                        
                    }
                ?>
            
                <label for="description">Descreva o animal:</label>
                <?php if(isset($_SESSION['email']) == true){
                        echo '<input type="text" class="form-control" id="animal_descrição" name="animal_descrição" required>';
                    } else {
                        echo '<input type="text" class="form-control" id="animal_descrição" name="animal_descrição" disabled>';
                        
                    }
                ?>

                <label for="animal">Animal:</label>
                <?php if(isset($_SESSION['email']) == true){
                        echo '<input type="text" class="form-control" id="animal_tipo" name="animal_tipo" required>';
                    } else {
                        echo '<input type="text" class="form-control" id="animal_tipo" name="animal_tipo" disabled>';
                        
                    }
                ?>

            </div>
            <div class="row">
                <div class="col-md-6 container_images">
                    <label for="arquivoAnimal">Foto do animal:</label>
                    <a id="imgInput" onclick="click_the_button(foto_animal);" class="inputButton"><i id="upload" class="far fa-arrow-alt-circle-up"></i></a>
                    <?php if(isset($_SESSION['email']) == true){
                                echo ' <img id="animalView" />';
                                } else {
                                echo ' <img id="animalViewSemLogin" class="border border-secondary" />';
                                }
                    ?>

                    <div>
                        <?php if(isset($_SESSION['email']) == true){
                                echo '<input type="file" id="foto_animal" name="foto_animal" onchange="loadFile(event)" accept="image/png, image/jpeg" required><br>';
                                } else {
                                echo '<input type="file" id="foto_animal" name="foto_animal" onchange="loadFile(event)" accept="image/png, image/jpeg" disabled><br>';
                                }
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">                        
                <h3>Localização</h3>
                <?php if(isset($_SESSION['email']) == true){
                        echo '<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <a id="buttonAcaoLogin" class="btn btn-primary mb-3 w-100" >Localização GPS <i class="fas fa-map-marked-alt"></i></a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <a id="buttonAcaoLogin" class="btn btn-primary mb-3 w-100" >Nome da rua <i class="fas fa-road"></i></a>
                                    </div>
                                </div>
                              </div>';
                        } else {
                        echo   '<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <a id="buttonSemAcao" class="btn btn-primary mb-3 w-100">Localização GPS <i class="fas fa-map-marked-alt"></i></a>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <a id="buttonSemAcao" class="btn btn-primary mb-3 w-100">Nome da rua <i class="fas fa-road"></i></a>
                                        </div>
                                    </div>
                                </div>';
                        }
                ?>
                <label for="CEP">CEP do local:</label>
                <?php if(isset($_SESSION['email']) == true){
                        echo '<input type="text" class="form-control" id="cep" onblur="pesquisacep(this.value);" name="cep" required>';
                        } else {
                        echo '<input type="text" class="form-control" id="cep" name="cep" disabled>';
                        }
                ?>

                <label for="address">Endereço em que foi visto pela última vez:</label>
                <?php if(isset($_SESSION['email']) == true){
                        echo '<input type="text" class="form-control" id="address" name="address" required>';
                        } else {
                        echo '<input type="text" class="form-control" id="address" name="address" disabled>';
                        }
                ?>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="number">Nº</label>
                        <?php if(isset($_SESSION['email']) == true){
                                echo '<input type="text" class="form-control" id="number" name="number" required>';
                                } else {
                                echo '<input type="text" class="form-control" id="number" name="number" disabled>';
                                }
                        ?>
                    </div>     
                </div>   
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="district">Bairro</label>
                        <?php if(isset($_SESSION['email']) == true){
                                echo '<input type="text" class="form-control" id="district" name="district" required>';
                                } else {
                                echo '<input type="text" class="form-control" id="district" name="district" disabled>';
                                }
                        ?>
                    </div>     
                </div>     

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="state">Estado</label>
                        <?php if(isset($_SESSION['email']) == true){
                                echo '<input type="text" class="form-control" id="state" name="state" required>';
                                } else {
                                echo '<input type="text" class="form-control" id="state" name="state" disabled>';
                                }
                        ?>
                    </div>     
                </div>     

            </div>
            <div class="form-group"> 
                <label for="observation">Observações sobre localização do animal, ponto de referência:</label>
                <?php if(isset($_SESSION['email']) == true){
                        echo ' <input type="text" class="form-control" id="observacao" name="observacao" required>';
                        } else {
                        echo ' <input type="text" class="form-control" id="observacao" name="observacao" disabled>';
                        }
                ?>
            </div>

            <div class="row">
                <div class="col-md-6 container_images">
                    <label for="arquivoAdress">Foto de um ponto de referência:</label>
                    <a id="imgInput" onclick="click_the_button(foto_address);" class="inputButton"><i id="upload" class="far fa-arrow-alt-circle-up"></i></a>
                    <?php if(isset($_SESSION['email']) == true){
                                echo ' <img id="addressPreview" />';
                                } else {
                                echo ' <img id="addressPreviewSemLogin" class="border border-secondary" />';
                                }
                    ?>

                    <div>
                        <?php if(isset($_SESSION['email']) == true){
                                echo '<input type="file" id="foto_address" name="foto_address" onchange="loadFilesnd(event)" accept="image/png, image/jpeg" required><br><br>';
                                } else {
                                echo '<input type="file" id="foto_address" name="foto_address" onchange="loadFilesnd(event)" accept="image/png, image/jpeg" disabled><br><br>';
                                }
                        ?>
                    </div>
                </div>
            </div>
            <?php 
                if(isset($_SESSION['email']) == true){
                    echo '<input class="btn btn-primary mb-3 w-100" type="submit" value="Reportar">';
                } else {
                    echo '<input class="btn btn-primary mb-3 w-100" type="submit" value="Sem Login" disabled>';
                    
                }
            ?>
        </form>
        
       <!-- Modal -->
        <div class="modal fade" id="modalLogin" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sem Login</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Se o usúario não estiver logado, o reporte não estará disponável</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Okay</button>
                </div>
            </div>
            
            </div>
        </div>
        
    </main>
    <?php
    require_once("includes/footer.php");
    ?>
    <script src="dashboard/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="dashboard/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="dashboard/js/report.js"></script>
    <script src="dashboard/js/previewImg.js"></script>
    <script src="dashboard/js/validCep.js"></script>
    <script src="dashboard/js/viacep.js"></script>

    <?php if(isset($_SESSION['email']) != true){ 
        echo "<script> $('#modalLogin').modal('toggle'); </script>"; 
    }?>

</body>

</html>