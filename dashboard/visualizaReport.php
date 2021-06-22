<?php
//Iniciando sessão
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (isset($_SESSION['email']) == true) {
    //Logou, então continua com as validações

} else { //Não logou então volta para a página inicial
    if (session_status() !== PHP_SESSION_ACTIVE) {
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
    <link rel="stylesheet" href="css_dashboard/report.css">
    <link rel="stylesheet" href="css_dashboard/maps.css">
    <link rel="stylesheet" href="css_dashboard/visualizarReport.css">
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
                $sql = $mysql->prepare("SELECT ar.ong_id,
                                                  u.name, 
                                                  u.phone,
                                                  ar.animal_type,
                                                  ar.animal_description,
                                                  a.location_cep,
                                                  a.location_address,
                                                  a.location_number,
                                                  a.location_district,
                                                  a.location_state,
                                                  a.location_observation,
                                                  ar.animal_photo,
                                                  a.location_photo,
                                                  ar.report_date_accepted,
                                                  ar.report_situation,
                                                  ar.report_img,
                                                  ar.report_comments
                                                FROM animal_report ar INNER JOIN user u ON (ar.author_id = u.id)
                                                                      INNER JOIN address a ON (ar.address_id = a.id)
                                                    WHERE ar.id = ?;");
                $sql->execute([$id]);
                //conta quantas linhas foram recebidas pelo banco de dados
                $count = $sql->rowCount();
                //testando se o banco obtem da informação requisitada
                if ($count < 1) {
                    header('Location: ./reports.php?msg=error_information');
                }
                //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) { //Caso ele não esteja, será impresso linha por linha do contéudo

                    $idOngReport = $linha['ong_id'];
                    $author = $linha['name'];
                    $phone = $linha['phone'];
                    $animal = ucfirst($linha['animal_type']);
                    $description = $linha['animal_description'];
                    $cep = $linha['location_cep'];
                    $location = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";
                    $pointOfReference = $linha['location_observation'];
                    $imgAnimal = $linha['animal_photo'];
                    $imgLocation = $linha['location_photo'];
                    $data_aceite = $linha['report_date_accepted'];
                    $situaReport = $linha['report_situation'];
                    $imagemReport = $linha['report_img'];
                    $comments = $linha['report_comments'];
                }

                //pegando o id da ong 
                $idOng  = $_SESSION['id'];
                ?>

                <div class="row">
                    <div class="col">
                        <h3 class="text-center"><strong>Visualização do Reporte
                                <?php if ($idOngReport == null) {
                                    echo '<a class="btn btn-warning" type="button" value="ongAccept" href="controller/vincularReport.php?id=' . $id . '">Ingresssar</a></strong></h3>';
                                } else {
                                    echo '<a class="btn btn-warning" type="button" id="botaoSemAcao">Ingresssar</a></strong></h3>';
                                }
                                ?>
                    </div>
                </div>

                <div class="d-flex flex-row-reverse">
                    <a class="btn btn-dark" type="button" href="reports.php">Voltar</a>
                </div>

                <form>
                    <!-- divs para colocar o autor, telefone e o animal em linhas até 576px -->
                    <div class="row">
                        <div class="col-sm">
                            <label for="author_name" class="m-0">
                                <h4>Autor</h4>
                            </label>
                            <input class="form-control w-100 mb-2" type="text" id="author_name" name="author_name" value='<?php echo $author ?>' readonly>
                        </div>

                        <div class="col-sm">
                            <label for="author_phone" class="m-0">
                                <h4>Telefone</h4>
                            </label>
                            <input class="form-control w-100 mb-2" type="text" id="author_phone" name="author_phone" value='<?php echo $phone ?>' readonly>
                        </div>

                        <div class="col-sm">
                            <label for="animal_description" class="m-0">
                                <h4>Animal</h4>
                            </label>
                            <input class="form-control w-100 mb-2" type="text" id="animal_description" name="animal_description" value='<?php echo $animal ?>' readonly>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="description" class="text-md">
                            <h4>Descrição</h4>
                        </label>
                        <input class="form-control w-100 mb-2" type="text" id="description" name="description" value='<?php echo $description ?>' readonly>
                    </div>

                    <!-- divs para colocar a localização e o ponto de referência em linha até 576px -->
                    <div class="row">
                        <div class="col-sm">
                            <label for="localization_lastview" class="m-0">
                                <h4>Localização</h4>
                            </label>
                            <input class="form-control w-100 mb-2" type="text" id="localization_lastview" name="localization_lastview" value='<?php echo $location ?>' readonly>
                        </div>

                        <div class="col-sm">
                            <label for="localization_observation" class="m-0">
                                <h4>Ponto de referência</h4>
                            </label>
                            <input class="form-control w-100 mb-2" type="text" id="localization_observation" name="localization_observation" value='<?php echo $pointOfReference ?>' readonly>
                        </div>

                    </div>

                    <!-- divs para colocar as imagens em linhas até 576px -->
                    <div class="row">

                        <div class="col-sm">
                            <h4 class="m-0">Foto animal</h4>
                            <img class="w-100 shadow border border-dark rounded " src="../imgsUpdate/<?php echo $imgAnimal ?>">
                        </div>

                        <div class="col-sm">
                            <h4 class="m-0">Foto do local</h4>
                            <img class="w-100 shadow border border-dark rounded" src="../imgsUpdate/<?php echo $imgLocation ?>">
                        </div>


                        <div class="col-sm">
                            <h4 class="m-0">Maps</h4>
                            <div class="w-100 shadow border border-dark rounded" id="map"></div>
                        </div>

                    </div>
                </form>
                <?php
                if ($idOngReport != 0 && $idOng == $idOngReport) { //Se o Id da ong for diferente de zero e igual o id for igual a atual ong logada, irá passar
                    if ($situaReport != 'rescued' && $situaReport != 'not_found') { //Se a situação do report for diferente de resgatado ou não achado irá mostra o código abaixo 
                        echo "<form id='formsGerenciar' action='controller/updateReport.php?id=" . $id . "' method='POST' enctype='multipart/form-data'>

                            <br><br>
                            <div class='row'>    
                                <div class='col'>
                                    <h3 class='text-center'><strong>Gerenciamento de reports</strong></h3>
                                </div>
                            </div>

                            <div class='container-fluid'>
                                <ul class='list-unstyled multi-steps'>
                                    <li>Report enviado</li>
                                    <li>Aceito pela ONG</li>
                                    <li class='is-active'>Resgatado</li>
                                </ul>
                            </div>

                            <div class='row'>
                                <div class='col-sm'>
                                    <label for='date_aceite'>Data de aceite</label>
                                    <input class='form-control w-100 mb-2' type='date' id='date_aceite' name='date_aceite' value='$data_aceite' readonly>
                                </div>

                                <div class='col-sm'>
                                    <div class='form-group'>
                                        <label for='reason'>Situação</label>
                                        <select id='reason' class='form-control' name='reason' required>
                                            <option value='waiting'" . ($situaReport == 'waiting' ? "selected" : "") . ">Aguardando</option>
                                            <option value='scheduled'" . ($situaReport == 'scheduled' ? "selected" : "") . ">Agendado</option>
                                            <option value='not_found'" . ($situaReport == 'not_found' ? "selected" : "") . ">Não localizado</option>
                                            <option value='rescued'" . ($situaReport == 'rescued' ? "selected" : "") . ">Resgatado</option>
                                        </select>
                                    </div>
                                </div>    
                            </div>

                            <div class='row'>
                                <div class='col-sm'>
                                    <div class='form-group'>
                                        <label for='comments'>Comentários</label>
                                        <textarea class='form-control' id='comments' name='comments' rows='3' maxlength='350' required>" . $comments . "</textarea> 
                                    </div>
                                </div>    
                            </div>
                            
                            <div class='row'>
                                <div class='col-md-6 container_images'>
                                    <p>Imagem de resgate <a onclick='clickInput(`animal_upload`)' class='inputButton'><i class='fas fa-cogs'></i></a></p>
                                    <img src='../imgsUpdate/$imagemReport' class='img-thumbnail' id='logo_upload'>
                                    <div class='custom-file'>
                                        <input type='file' name='arquivo' id='animal_upload' onchange='loadFile(event)' accept='image/png, image/jpeg'/>
                                        <p style='display: none' id='mensagem' class='text-danger'>A imagem não foi upada</p>
                                    </div>
                                </div> 
                            </div>

                            <div class='row'>
                                <div class='col-sm'>
                                    <input class='btn btn-primary w-100 mb-2' type='submit' value='Concluido'>
                                </div>

                                <div class='col-sm'>
                                    <a class='btn btn-dark w-100 mb-2' type='button' href='controller/desvincularReport.php?id=" . $id . "'>Abandonar</a>
                                </div>
                            </div>";
                    } else{//se caso o report for igual resgatado ou não encontrado, irá cair aqui
                        echo "<form id='formsGerenciar' action='controller/updateReport.php?id=" . $id . "' method='POST' enctype='multipart/form-data'>

                            <br><br>
                            <div class='row'>    
                                <div class='col'>
                                    <h3 class='text-center'><strong>Gerenciamento de reports</strong></h3>
                                </div>
                            </div>

                            <div class='container-fluid'>
                                <ul class='list-unstyled multi-steps'>
                                    <li>Report enviado</li>
                                    <li>Aceito pela ONG</li>
                                    <li>Resgatado</li>
                                </ul>
                            </div>

                            <div class='row'>
                                <div class='col-sm'>
                                    <label for='date_aceite'>Data de aceite</label>
                                    <input class='form-control w-100 mb-2' type='date' id='date_aceite' name='date_aceite' value='$data_aceite' readonly>
                                </div>

                                <div class='col-sm'>
                                    <div class='form-group'>
                                        <label for='reason'>Situação</label>
                                        <select class='form-control' id='reason' name='reason' disabled>
                                            <option value='waiting' " . ($situaReport == 'waiting' ? "selected" : "") . ">Aguardando</option>
                                            <option value='scheduled' " . ($situaReport == 'scheduled' ? "selected" : "") . ">Agendado</option>
                                            <option value='not_found' " . ($situaReport == 'not_found' ? "selected" : "") . ">Não localizado</option>
                                            <option value='rescued' " . ($situaReport == 'rescued' ? "selected" : "") . ">Resgatado</option>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            
                            <div class='row'>
                                <div class='col-sm'>
                                    <div class='form-group'>
                                        <label for='comments'>Comentários</label>
                                        <textarea class='form-control' id='comments' name='comments' rows='3' maxlength='350' disabled>" . $comments . "</textarea> 
                                    </div>
                                </div>    
                            </div>

                            <div class='row'>
                                <div class='col-md-6 container_images'>
                                    <p>Imagem de resgate <a onclick='clickInput(`animal_upload`)' class='inputButton'><i class='fas fa-cogs'></i></a></p>
                                    <img src='../imgsUpdate/$imagemReport' class='img-thumbnail' id='logo_upload'>
                                    <div class='custom-file'>
                                        <input type='file' name='arquivo' id='animal_upload' onchange='loadFile(event)' accept='image/png, image/jpeg' disabled/>
                                    </div>
                                </div> 
                            </div>
                            
                            <div class='row'>
                                <div class='col-sm'>
                                    <input class='btn btn-primary w-100 mb-2' type='submit' value='Concluido' disabled>
                                </div>

                                <div class='col-sm'>
                                    <a class='btn disabled btn-dark w-100 mb-2' type='button' href='controller/desvincularReport.php?id=" . $id . "'>Abandonar</a>
                                </div>
                            </div>";
                    }
                }
                ?>

                <?php
                //Incluindo o footer na página
                include "includes/footer.php";
                ?>
            </div>
        </main>
    </div>
    <script src="js/global.js"></script>
    <script src="plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_APIKEY"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">var address = "<?= $location ?>";</script>
    <script src="js/visualizaReport.js"></script>
    <?php

    //verificando se existe uma mensagem na URL da página
    if (isset($_GET['msg'])) { //Se existe ele cairá neste if, se não, continuará a operação normalmente

        $msg = $_GET['msg']; // Colocando a mensagem em uma variável
        $_COOKIE['msg'] = $msg; // Colocando ela em cookie para conseguir pegar em outro script

        if ($msg == "sucess_acceptedReport") { //Se a mensagem for de sucesso ao vincular cairá aqui
            $nameOng = $_SESSION['name'];
            $_COOKIE['name'] = $nameOng;
        } elseif ($msg == "sucess_unlinkReport") { //Se a mensagem for de de sucesso ao desvincular cairá aqui 
            $nameOng = $_SESSION['name'];
            $_COOKIE['name'] = $nameOng;
        } elseif ($msg == "invalid_size_animal") { //se a mensagem for de tamanho inválido cairá aqui
            $tamanho = $_GET['size'];
            $_COOKIE['size'] = $tamanho;
        }
        include '../includes/modal.php'; //incluindo o modal para a página
    }
    ?>
</body>

</html>