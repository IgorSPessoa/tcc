<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!--Requisitos de tags meta-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard/plugins/fontawesome/css/all.min.css">

    <!--ico-->
    <link rel="shortcut icon" type="image" href="./imgs/CF.ico">

    <!--Css-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/resetcss.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/report.css">
    <link rel="stylesheet" href="dashboard/plugins/bootstrap/css/bootstrap.min.css">
    <title>Reportar</title>
</head>

<body>
    <?php
    //Iniciando sessão
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (isset($_SESSION['email']) == true) {
        //Logou, então continua com as validações
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
    <main class="pb-3">
        <div class="container">
            <div class="text-center">
                <h2 class="text-uppercase">Animal em perigo? Reporte aqui!</h2>
                <p class="text-uppercase">Nossas ONG cadastradas serão informadas sobre isto.</p>
            </div>
        </div>

        <?php if (isset($_SESSION['email']) != true) { //Se não estiver com alguma conta logada, mostrará o conteúdo abaixo
            echo '<center> Não está logado? <a href="login.php">Logue aqui</a>, Não tem uma conta? <a href="criar_conta.php">Crie aqui</a> </center>';
        } ?>
        <form class="w-100 bg-white shadow lg-3 border border-3 border-primary px-5 py-5" action="controller/emulator_animal_report.php" enctype="multipart/form-data" runat="server" method="POST">

            <!--Método: --
                Parâmetros: [ -- ]
                Objetivo: Cada php aberto nesta página verifica se existe um usuário logado, caso não tenha, todas as funções abaixos estarão indisponiveis. 
            -->

            <div class="form-group">
                <h3>Sobre o animal</h3>
                <label for="situation">Qual é a situação do animal?</label>

                <?php if (isset($_SESSION['email']) == true) {
                    echo '<input type="text" class="form-control" id="situacao_animal" maxlength="200" name="situacao_animal" required>';
                } else {
                    echo '<input type="text" class="form-control" id="situacao_animal" name="situacao_animal" disabled>';
                }
                ?>

                <label for="description">Descreva o animal:</label>
                <?php if (isset($_SESSION['email']) == true) {
                    echo '<textarea class="form-control " id="animal_descrição" name="animal_descrição" rows="3" maxlength="200" required></textarea>';
                } else {
                    echo '<textarea class="form-control" id="animal_descrição" name="animal_descrição" rows="3" disabled></textarea>';
                }
                ?>

                <label class="pt-3" for="animal">Animal:</label>
                <?php if (isset($_SESSION['email']) == true) {
                    echo '<select class="form-control" id="animal_tipo" name="animal_tipo" required>
                                <option value="" selected>Selecione...</option>
                                <option value="dog">Cachorro</option>
                                <option value="cat">Gato</option>
                                <option value="others">Outros</option>
                            </select>';
                } else {
                    echo '<select class="form-control" id="animal_tipo" name="animal_tipo" disabled>
                                <option selected>Selecione...</option>
                                <option value="dog">Cachorro</option>
                                <option value="cat">Gato</option>
                                <option value="others">Outros</option>
                            </select>';
                }
                ?>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="arquivoAnimal">Foto do animal:</label>
                    <a id="imgInput" onclick="click_the_button(foto_animal);" class="inputButton"><i id="upload" class="far fa-arrow-alt-circle-up"></i></a><br />
                    <?php if (isset($_SESSION['email']) == true) {
                        echo ' <img src="imgs/preview.jpg" id="animalView" />';
                    } else {
                        echo ' <img id="animalViewSemLogin" class="border border-secondary" />';
                    }
                    ?>

                    <div>
                        <?php if (isset($_SESSION['email']) == true) {
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
                <?php if (isset($_SESSION['email']) == true) {
                    echo '<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <a id="buttonAcaoLogin" class="btn btn-primary mb-3 w-100" onclick="getLocation()">Localização GPS <i class="fas fa-map-marked-alt"></i></a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <a id="buttonAcaoLogin" class="btn btn-primary mb-3 w-100" data-toggle="modal" data-target="#modalRua">Nome da rua <i class="fas fa-road"></i></a>
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
                <?php if (isset($_SESSION['email']) == true) {
                    echo '<input type="text" class="form-control" id="cep" name="cep" onblur="pesquisacep(this.value);"  value="" required>';
                } else {
                    echo '<input type="text" class="form-control" id="cep" name="cep" disabled>';
                }
                ?>

                <label for="address">Endereço em que foi visto pela última vez:</label>
                <?php if (isset($_SESSION['email']) == true) {
                    echo '<input type="text" class="form-control" id="address" name="address" maxlength="150" value="" required>';
                } else {
                    echo '<input type="text" class="form-control" id="address" name="address" disabled>';
                }
                ?>
            </div>
            <div class="row mb-3">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="district">Bairro</label>
                        <?php if (isset($_SESSION['email']) == true) {
                            echo '<input type="text" class="form-control" id="district" maxlength="50" name="district" value="" required>';
                        } else {
                            echo '<input type="text" class="form-control" id="district" name="district" disabled>';
                        }
                        ?>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="state">Estado</label>
                        <?php if (isset($_SESSION['email']) == true) {
                            echo '<input type="text" class="form-control" id="state" maxlength="50" name="state" value="" required>';
                        } else {
                            echo '<input type="text" class="form-control" id="state" name="state" disabled>';
                        }
                        ?>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="number">Nº</label>
                        <?php if (isset($_SESSION['email']) == true) {
                            echo '<input type="text" class="form-control" id="number" maxlength="10" name="number" required>';
                        } else {
                            echo '<input type="text" class="form-control" id="number" name="number" disabled>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="observation">Observações sobre localização do animal, ponto de referência:</label>
                <?php if (isset($_SESSION['email']) == true) {
                    echo ' <textarea type="text" class="form-control" id="observacao" name="observacao" rows="3" maxlength="200" required></textarea>';
                } else {
                    echo ' <textarea type="text" class="form-control" id="observacao" name="observacao" rows="3" disabled></textarea>';
                }
                ?>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="arquivoAdress">Foto de um ponto de referência:</label>
                    <a id="imgInput" onclick="click_the_button(foto_address);" class="inputButton"><i id="upload" class="far fa-arrow-alt-circle-up"></i></a><br />
                    <?php if (isset($_SESSION['email']) == true) {
                        echo ' <img src="imgs/preview.jpg" id="addressPreview" />';
                    } else {
                        echo ' <img id="addressPreviewSemLogin" class="border border-secondary" />';
                    }
                    ?>

                    <div>
                        <?php if (isset($_SESSION['email']) == true) {
                            echo '<input type="file" id="foto_address" name="foto_address" onchange="loadFilesnd(event)" accept="image/png, image/jpeg" required><br><br>';
                        } else {
                            echo '<input type="file" id="foto_address" name="foto_address" onchange="loadFilesnd(event)" accept="image/png, image/jpeg" disabled><br><br>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
            if (isset($_SESSION['email']) == true) {
                echo '<input class="btn btn-primary mb-3 w-100" type="submit" value="Reportar">';
            } else {
                echo '<input class="btn btn-primary mb-3 w-100" type="submit" value="Sem Login" disabled>';
            }
            ?>

            <!-- Modal -->
            <div class="modal fade" id="modalRua" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Endereço</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="form_modal" onsubmit="return false">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nome da rua onde o animal está</label>
                                    <input type="text" class="form-control" id="modalAddress" name="modalAddress" value="">
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id="valueAddress">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </main>
    <script src="dashboard/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=YOU_APIKEY"></script>
    <script src="dashboard/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/reportar.js"></script>
    <script src="js/global.js"></script>
    <?php
    //Adicionando o footer
    require_once("includes/footer.php");

    //Verificando se existe um email logado, se não irá enviar uma mensagem de error de login
    if (isset($_SESSION['email']) != TRUE) {
        //definindo a mensagem
        $msg = "errorLoginReport";

        // Colocando-a em cookie para conseguir pegar em outro script
        $_COOKIE['msg'] = $msg;
    }

    //verificando se existe uma mensagem na URL da página
    if (isset($_GET['msg'])) { //Se existe ele cairá neste if, se não, continuará a operação normalmente
        $msg = $_GET['msg']; // Colocando a mensagem em uma variável
        $_COOKIE['msg'] = $msg; // Colocando-a em cookie para conseguir pegar em outro script

        if ($msg == "invalid_size_animal") { //Se a mensagem for de erro do tamanho da imagem do animal cairá aqui  
            $tamanho = $_GET['size'];
            $_COOKIE['size'] = $tamanho;
        } else if ($msg == "invalid_size_location") { //Se a mensagem for de erro do tamanho da imagem do localização cairá aqui    
            $tamanho = $_GET['size'];
            $_COOKIE['size'] = $tamanho;
        }
    }

    // Precisa ficar aqui embaixo para verificar os cookies
    include 'includes/modal.php';
    ?>
</body>

</html>