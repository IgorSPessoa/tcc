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


$dados = $mysql->query("SELECT * FROM animal_report WHERE id = $id;"); 
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
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
</head>
<body>
    <?php include "include/sidenav.php"; ?>
    <main>
        <div class="container_form">
            <form>
                <div class="container_title">
                    <div>
                        <h2>Report</h2>
                        <p>Verifique informações do report aqui</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" onclick="window.location='reports.php';" id="back_button"> Voltar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Informações do autor</h5>    
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="first">Nome Completo</label>
                            <input type="text" class="form-control" id="author_name" name="author_name" value="<?php echo $linha['author_name'];?>" readonly>
                        </div>                 
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="first">Telefone</label>
                            <input type="text" class="form-control" id="author_phone" name="author_phone" value="<?php echo $linha['author_phone'];?>" readonly>
                        </div>       
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5>Informações do animal</h5>    
                    </div>
                
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first">Situação</label>
                            <input type="text" class="form-control" id="animal_situation" name="animal_situation" value="<?php echo $linha['animal_situation'];?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first">Descrição do animal</label>
                            <input type="text" class="form-control" id="animal_description" name="animal_description" value="<?php echo $linha['animal_description'];?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first">Imagem do animal</label><br>
                            <img src="imgs/animal.png" alt="" id="img_lock" name="first">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5>Localização</h5>    
                    </div>
                
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first">Endereço</label>
                            <input type="text" class="form-control" id="first" value="<?php echo $linha['localization_lastview']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first">Ponto de referência</label>
                            <input type="text" class="form-control" id="first" value="<?php echo $linha['localization_observation']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first"><b>Ref Imagem</b></label><br>
                            <img src="imgs/ref.jpg" alt="" id="img_lock">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first"><b>Mapa</b></label><br>
                            <div id='map' style='width: 400px; height: 300px;'></div>
                        </div>
                    </div>

                <div class="col-md-12">
                    <h5>Ações</h5>   

                    <button type="button" class="btn btn-danger">Atender este caso</button>
                    <button type="button" class="btn btn-warning">Reportar como inválido</button> 
                </div>
            </div>

            </form>
            <br>
        </div>

        <script>
            mapboxgl.accessToken = 'pk.eyJ1IjoiaWtub3dicjEyIiwiYSI6ImNrbTVlMGlzYjBkZm8ydnFicTZyeTdnMDkifQ.sUKyZ4tPE2WVUklcUVd7ZA';
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [-46.7891539, -23.7297985], //-23.728028,-46.7864355
                zoom: 15.0
            });
                                    
            map.on('load', function () {
            map.addSource('places', {
                'type': 'geojson',
                'data': {
                    'type': 'FeatureCollection',
                    'features': []
                }
            }
            );

            // Add a layer showing the places.
            map.addLayer({
                'id': 'places',
                'type': 'symbol',
                'source': 'places',
                'layout': {
                'icon-image': '{icon}-15',
                'icon-allow-overlap': true
            }
            });
                    
            // When a click event occurs on a feature in the places layer, open a popup at the
            // location of the feature, with description HTML from its properties.
            map.on('click', 'places', function (e) {
            var coordinates = e.features[0].geometry.coordinates.slice();
            var description = e.features[0].properties.description;
            
            // Ensure that if the map is zoomed out such that multiple
            // copies of the feature are visible, the popup appears
            // over the copy being pointed to.
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }
            
            new mapboxgl.Popup()
                .setLngLat(coordinates)
                .setHTML(description)
                .addTo(map);
            });

            var popup = new mapboxgl.Popup({ offset: 25 }).setText(
                'Posição informada pelo usuário'
            );

            var marker = new mapboxgl.Marker()
                .setLngLat([-46.7891539, -23.7297985])
                .setPopup(popup)
                .addTo(map);

            // Change the cursor to a pointer when the mouse is over the places layer.
            map.on('mouseenter', 'places', function () {
                map.getCanvas().style.cursor = 'pointer';
            });
            
            // Change it back to a pointer when it leaves.
            map.on('mouseleave', 'places', function () {
                map.getCanvas().style.cursor = '';
                });
            });
        </script>
    </main>
</body>
</html>