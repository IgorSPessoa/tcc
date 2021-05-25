<?php
include "connect.php";

$id = $_GET['id'];

$result = $mysql->prepare("SELECT * FROM ong WHERE id = $id;");
$result->execute();

while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
    $name = $linha['ong_name'];
    $ong_opening_date = $linha['ong_opening_date'];
    $ong_business_hours = $linha['ong_business_hours'];
    $description = $linha['ong_description'];
    $img = $linha['ong_img'];
    $address = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";
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
    <link rel="stylesheet" href="css/Ong_Profile.css">
    <link rel="stylesheet" href="css/maps.css">

    <title>Perfil Ong</title>
</head>

<body>
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
    <main>
    <div class="p-3 d-flex justify-content-center">
        <div class="descricao bg-white shadow-lg border border-3 border-primary px-5 py-2" id="container_descriptionOng">
            <div class="LOng p-3 d-flex justify-content-center">
                <img src="./imgs/<?php echo $img;  ?>" alt="">
            </div>

            <h2><?php echo $name; ?></h2>
            <p><b>Descrição:</b> <?php echo $description;  ?></p>
            <p><b>Aberta desde:</b> <?php echo $ong_opening_date; ?></p>
            <p><b>Horario de Atendimento:</b> <?php echo $ong_business_hours;  ?></p>

        </div>
    </div>

    <div class="p-3 d-flex justify-content-center">
        <div class="descricao bg-white border border-3 border-primary px-5 py-2" id="container_mapAddress"> 
            <h2 class="m-0">Mapa</h2>
            <div class="LOng pt-3 pb-3 d-flex justify-content-center" id="container-map" >
                <div class="w-100 shadow border border-dark rounded" id="map"></div>
            </div>

            <p><b>Endereço:</b> <?php echo $address;  ?></p>
        </div>
    </div>

    <div class="adocao container p-2 w-100 h-80 justify-content-center">
        <h1>Animais para adoação nesta ONG</h1>

        <div class="animals">
            <?php
            //definir o número total de resultados que você deseja por página
            $results_per_page = 9;

            //encontre o número total de resultados armazenados no banco de dados  
            $query = $mysql->prepare("SELECT * FROM animal_adoption WHERE ong_id = $id;");
            $query->execute();
            $number_of_result = $query->rowCount();
            //determinar o número total de páginas disponíveis
            $number_of_page = ceil($number_of_result / $results_per_page);

            //determinar em qual número de página o visitante está atualmente
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            //determinar o número inicial de sql LIMIT para os resultados na página de exibição  
            $page_first_result = ($page - 1) * $results_per_page;

            $dados = $mysql->prepare("SELECT id, animal_name, animal_description, animal_photo FROM animal_adoption WHERE ong_id = $id LIMIT $page_first_result, $results_per_page;");
            $dados->execute();

            //exibir o resultado recuperado na página da web 
            //while ($row = mysqli_fetch_array($result))
            while ($linha = $dados->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='animal justify-content-center bg-white shadow lg-3 border border-3 border-primary px-5 py-2'>
                    <span>" . $linha['animal_name'] . "</span>
                
                    <img src='imgs/" . $linha['animal_photo'] . "' alt='Imagem de um cachorro'>
                    <br><br>
                    <a href='animal_profile.php?id=" . $linha['id'] . "' class='button'>Visualizar informações</a>
                    <br><br>
                </div>";
            }
            /*
            $dados = $mysql->prepare("SELECT name, description, img, id FROM animal_adoption WHERE ong_id = $id;");
            $dados->execute();

            while ($linha = $dados->fetch(PDO::FETCH_BOTH)) {
                echo "<div class='animal bg-white shadow lg-3 border border-3 border-primary px-5 py-2'>
                            <span>$linha[0]</span>
                            <p>$linha[1]</p>
                            <img src='imgs/$linha[2]' alt='Imagem de um cachorro'>
                            <br><br>
                            <a href='animal_profile.php?id=$linha[3]' class='btn btn-outline-dark'>Visualizar informações</a>
                            <br><br>
                        </div>";
            }*/
                ?>
            </div>
            <br>
            <div class="d-flex justify-content-center">
                <?php
                //set de variaveis para paginação.
                $pagina_anterior = $page - 1;
                $pagina_proxima = $page + 1;
                $page_atual = $page;

                if ($number_of_result >= 1) {
                    //Testa se pode ter o botão de pagina anterior ou não.
                    if ($pagina_anterior != 0) {
                        echo '<a href = "ong_profile.php?id=' . $id . '&page=' . $pagina_anterior . '" class="btn button text-center"> << </a>';
                    } else {
                        echo '<a href="#" class="btn button disabled" role="button" aria-disabled="true"> << </a>';
                    }
                    //imprime os button de paginação até 5 (para limitar bloco de paginação).
                    for ($page = 1; $page <= 5 && $page <= $number_of_page; $page++) {
                        echo '<a href = "ong_profile.php?id=' . $id . '&page=' . $page . '" class="button text-center">' . $page . ' </a>';
                    }
                    /*
            Testa se o numero de paginas vai ser maior que 5 (para limitar bloco de paginação),
            se for ele imprime o button para a proxima pagina. 
            */
                    if ($number_of_page > 5) {
                        if ($page_atual < $number_of_page) {
                            echo '<a href="#" class="btn button disabled" role="button" aria-disabled="true">...</a>';
                            echo '<a href = "ong_profile.php?id=' . $id . '&page=' . $pagina_proxima . '" class="button text-center">' . $pagina_proxima . ' </a>';
                        } else {
                            echo '<a href="#" class="btn button disabled" role="button" aria-disabled="true">...</a>';
                            echo '<a href = "ong_profile.php?id=' . $id . '&page=' . $page_atual . '" class="button text-center">' . $page_atual . ' </a>';
                        }
                    }
                    //Testa se pode ter o botão de proxima pagina ou não.
                    if ($pagina_proxima <= $number_of_page) {
                        echo '<a href = "ong_profile.php?id=' . $id . '&page=' . $pagina_proxima . '" class="btn button text-center"> >> </a>';
                    } else {
                        echo '<a href="#" class="btn button disabled" role="button" aria-disabled="true"> >> </a>';
                    }
                }
                ?>
            </div>
        </div>
    </main>
    <?php
    //incluindo o modal na página
    require_once("includes/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo"></script>
    <script type="text/javascript">var address = "<?= $address ?>";</script>
    <script src="js/ong_profile.js"></script>
    <script src="js/global.js"></script>
</body>

</html>
