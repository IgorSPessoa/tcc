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
                   $sql = $mysql->prepare("SELECT 	ar.*, u.name, u.phone
                                                FROM animal_report ar INNER JOIN user u ON (ar.author_id = u.id)
                                                    WHERE ar.id = ?;");
                   $sql->execute([$id]);
 
                   //Colocando o resultado da pesquisa na variavel $linha por meio de arrays
                   while($linha = $sql->fetch(PDO::FETCH_ASSOC)){ //Caso ele não esteja, será impresso linha por linha do contéudo
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
                        <?php if($idOngReport == 0){
                            echo'<a class="btn btn-warning" type="button" value="ongAccept" href="controller/vincularReport.php?id=' . $id . '">Ingresssar</a></strong></h3>';
                        } else {
                            echo'<a class="btn btn-warning" type="button" id="botaoSemAcao">Ingresssar</a></strong></h3>';
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
                            <label for="author_name" class="m-0"><h4>Autor</h4></label>
                            <input class="form-control w-100 mb-2" type="text" id="author_name" name="author_name" value='<?php echo $author?>' readonly>
                        </div>

                        <div class="col-sm">
                            <label for="author_phone" class="m-0"><h4>Telefone</h4></label>
                            <input class="form-control w-100 mb-2" type="text" id="author_phone" name="author_phone" value='<?php echo $phone?>' readonly> 
                        </div>

                        <div class="col-sm">
                            <label for="animal_description" class="m-0"><h4>Animal</h4></label>
                            <input class="form-control w-100 mb-2" type="text"  id="animal_description" name="animal_description" value='<?php echo $animal?>' readonly>
                        </div>
                    
                    </div>

                    <div class="form-group">
                        <label for="description" class="text-md"><h4>Descrição</h4></label>
                        <input class="form-control w-100 mb-2" type="text" id="description" name="description" value='<?php echo $description?>' readonly>
                    </div>
                    
                    <!-- divs para colocar a localização e o ponto de referência em linha até 576px -->
                    <div class="row">
                        <div class="col-sm">
                            <label for="localization_lastview" class="m-0"><h4>Localização</h4></label>
                            <input class="form-control w-100 mb-2" type="text" id="localization_lastview" name="localization_lastview" value='<?php echo $location?>' readonly>
                        </div>

                        <div class="col-sm">
                            <label for="localization_observation" class="m-0"><h4>Ponto de referência</h4></label>
                            <input class="form-control w-100 mb-2" type="text" id="localization_observation" name="localization_observation" value='<?php echo $pointOfReference?>' readonly> 
                        </div>
                    
                    </div>

                    <!-- divs para colocar as imagens em linhas até 576px -->
                    <div class="row">

                        <div class="col-sm">
                            <h4 class="m-0">Foto animal</h4>
                            <img class="w-100 shadow border border-dark rounded " src="../imgs/<?php echo $imgAnimal?>">
                        </div>

                        <div class="col-sm">
                            <h4 class="m-0">Foto do local</h4>
                            <img class="w-100 shadow border border-dark rounded" src="../imgs/<?php echo $imgLocation?>">
                        </div>

                        
                        <div class="col-sm">
                            <h4 class="m-0">Maps</h4>
                            <div class="w-100 shadow border border-dark rounded" id="map"></div>
                        </div>

                    </div>
                </form>
                <?php 
                // <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                // <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    if( $idOngReport != 0 && $idOng == $idOngReport){
                        echo "<form id='formsGerenciar' action='controller/updateReport.php?id=" . $id . "' method='POST' enctype='multipart/form-data'>

                        <br><br>
                        <div class='row'>    
                            <div class='col'>
                                <h3 class='text-center'><strong>Gerenciamento de reports</strong></h3>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='container'>
                                <ul class='progressbar'>
                                <li><a href='#' class='active'>Report Enviado</a></li>
                                <li><a href='#' class='active none-active'>Aceito por ONG</a></li>
                                <li><a href='#' " . ($situaReport == 'rescued' ? "class='active'" : "") . ">Resgatado</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-sm'>
                                <label for='date_aceite'>Data de aceite</label>
                                <input class='form-control w-100 mb-2' type='date' id='date_aceite' name='date_aceite' value='$data_aceite' readonly>
                            </div>

                            <div class='col-sm'>
                                <div class='form-group'>
                                    <label for='reason'>Situação</label>
                                    <select class='form-control' id='reason' name='reason' required>
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
                                    <textarea class='form-control' id='comments' name='comments' rows='3' required>" . $comments . "</textarea> 
                                </div>
                            </div>    
                        </div>

                        <div class='row'>
                            <div class='col-md-6 container_images'>
                                <p>Imagem de resgate <a onclick='clickInput(`logo_input`)' class='inputButton'><i class='fas fa-cogs'></i></a></p>
                                <img src='../imgs/$imagemReport' class='img-thumbnail' id='logo_upload'>
                                <div class='custom-file'>
                                    <input type='file' name='arquivo' id='logo_input' onchange='loadFile(event)' accept='image/png, image/jpeg'/>
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
                        }
                ?>

                <?php include "includes/footer.php"; ?>
            </div>
        </main>
    </div>

    <script src="js/global.js"></script>
    <script src="plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>
    <script src="js/perfil.js"></script>
    <script src="js/previewLogo.js"></script>
    <script src="http://maps.google.com/maps/api/js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo&callback=initMap"></script>
    <script>
        const chave = "AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo";
        const address = "<?php echo $location; ?>";

        let url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${chave}`;
        fetch(url)
        .then(response => response.json())
        .then( data => {
            let LatLng = data.results[0].geometry.location;
            let latLocation = data.results[0].geometry.location.lat;
            let lngLocation = data.results[0].geometry.location.lng;

            map = new google.maps.Map(document.getElementById('map'),{
                center: {lat: latLocation, lng: lngLocation},
                zoom: 18      
              });
        })
        .catch(err => console.warn(err.message));
       
    </script>

</body>
</html>