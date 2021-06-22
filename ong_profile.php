<?php
include "connect.php";

$id = $_GET['id'];

//verificar se existe algo no id 
if ($id == "") {
    header('Location: ongs.php?msg=error_id');
}

$result = $mysql->prepare("SELECT o.ong_name,
                                  o.ong_opening_date,
                                  o.ong_business_hours,
                                  o.ong_description,
                                  o.ong_img, 
                                  o.ong_whatsapp,
                                  o.ong_facebook_url,
                                  a.location_address,
                                  a.location_number,
                                  a.location_district,
                                  a.location_state FROM ong o INNER JOIN address a ON (o.address_id = a.id) WHERE o.id = ?;");
$result->execute([$id]);

//verficando se houve resultado para na query
$rows = $result->rowCount();
if ($rows >= 1) { // se existe algum resultado, irá pegar os dados 
    while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
        $name = $linha['ong_name'];
        $ong_opening_date = $linha['ong_opening_date'];
        $ong_business_hours = $linha['ong_business_hours'];
        $description = $linha['ong_description'];
        $img = $linha['ong_img'];
        $whatsapp = $linha['ong_whatsapp'];
        $facebook = $linha['ong_facebook_url'];
        $address = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";

        //verificar se a variavel não está vazia
        if ($whatsapp != null) { // se não estiver vazio, irá mostrar o número
            //Colocando os carácteres de formatção de número
            $resultWhats = substr_replace($whatsapp, '(', 0, 0);
            $resultWhats = substr_replace($resultWhats, ')', 3, 0);
            $resultWhats = substr_replace($resultWhats, ' ', 4, 0);
            $resultWhats = substr_replace($resultWhats, '-', 10, 0);
            $whatsapp = $resultWhats;
        } else { //Se estiver vazia, irá mostrar a mensagem
            $whatsapp = 'Nenhum número associado a ong';
        }
    }
} else { //se não existir resultados na query, irá redirecionar com um erro
    header('Location: ongs.php?msg=error_information');
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
    <link rel="stylesheet" href="dashboard/plugins/fontawesome/css/all.min.css">

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
    <section class="container py-3">
        <div class="main-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card border border-dark">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="./imgsUpdate/<?php echo $img;  ?>" alt="Logo da ong" height="250" width="250">
                                <div class="mt-3">
                                    <h4><?php echo $name; ?></h4>
                                    <p class="lead text-left mb-1"><b>Descrição:</b> <?php echo $description;  ?></p>
                                    <p class="lead text-left mb-1"><b>Aberta desde:</b> <?php echo $ong_opening_date; ?></p>
                                    <p class="lead text-left mb-1"><b>Horario de Atendimento:</b> <?php echo $ong_business_hours; ?></p>
                                    <p class="lead text-left mb-1"><b>Whatsapp: </b><?php echo $whatsapp; ?></p>
                                    <p class="lead text-left mb-1"><b>Facebook:</b> 
                                    <?php
                                        //verificar se a variavel não está vazia
                                        if ($facebook != null) { // se não estiver vazio, irá mostrar o url
                                            echo "<a href='$facebook'>", $facebook, "</a>";
                                        } else { //Se estiver vazia, irá mostrar a mensagem
                                            echo 'Nenhum facebook associado a ong';
                                        }
                                    ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3 border border-dark">
                        <div class="card-body">
                            <h3 class="text-center m-0">Localização da ong</h3>
                            <div class="LOng pt-3 pb-3 d-flex justify-content-center" id="container-map">
                                <div class="w-100 shadow border border-dark rounded" id="map"></div>
                            </div>
                            <p class="lead text mb-3"><b>Endereço:</b> <?php echo $address;  ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="adocao container p-2 w-100 h-80 justify-content-center">
        <h1>Animais para adoação nesta ONG</h1>
        <hr />
        <?php
        //encontre o número total de resultados armazenados no banco de dados  
        $sql = $mysql->prepare("SELECT * FROM animal_adoption WHERE ong_id = $id;");
        $sql->execute();
        $resultRows = $sql->rowCount();

        //verificando se não está vazio
        if ($resultRows == 0) {
            echo "<h4 class='text-center'>Nenhum animal para adoção nesta ONG!</h2>";
        }
        ?>
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
            while ($linha = $dados->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='animal justify-content-center bg-white shadow lg-3 border border-3 border-primary px-5 py-2'>
                    <span>" . $linha['animal_name'] . "</span>
                
                    <img src='imgsUpdate/" . $linha['animal_photo'] . "' alt='Imagem de um cachorro'>
                    <br><br>
                    <a href='animal_profile.php?id=" . $linha['id'] . "' class='button'>Visualizar informações</a>
                    <br><br>
                </div>";
            }
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_APIKEY"></script>
    <script type="text/javascript">
        var address = "<?= $address ?>";
    </script>
    <script src="js/ong_profile.js"></script>
    <?php
    //incluindo o modal na página
    require_once("includes/footer.php");

    //chamando um ajax para conseguir somar visualização do usuario a página
    if (isset($_SESSION['email']) == true) {
        echo "<script type='text/javascript'> 
                $.ajax({
                    type: 'GET',
                    url:'js/visualizacao.js',
                    data: $id
                });
              </script>";
    }
    ?>
</body>

</html>