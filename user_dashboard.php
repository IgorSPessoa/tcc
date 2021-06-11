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
    <link rel="stylesheet" href="css/user_dashboard.css">
    <link rel="stylesheet" href="css/maps.css">

    <title>Home User</title>
</head>

<body class="bg-dark">
    <?php
    //Iniciando o sessão
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    //verificando se tem um email por SESSION
    if (isset($_SESSION['email']) == true) {
        //Logou, então o nav vai ser incluido
        require_once("includes/nav.php");
    } else { //Não logou então volta para a página inicial
        unset($_SESSION['email']);
        unset($_SESSION['acc_type']);
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_unset();
        session_destroy();
        echo "<script language='javascript' type='text/javascript'>window.location = ' login.php';</script>";
    }
    ?>
    <main>
        <div class='d-flex flex-row-reverse p-1'>
            <a href='logout.php' class='button btn btn-danger'> Sair</a>
        </div>
        <?php
        //conexão com banco de dados
        include "connect.php";

        $id_user = $_SESSION['id'];
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];

        $sql = $mysql->prepare("SELECT * FROM tcc.user where id= $id_user");
        $sql->execute();
        while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
            $pwd_user = $linha['pwd'];
            $img_user = $linha['img'];
            $phone_user = $linha['phone'];
            $cep_user = $linha['cep'];
            $dataconta_user = $linha['created_at'];
        }
        echo "
        <div class='d-flex justify-content-center'>
            <img src='./imgsUpdate/$img_user' class='perfilimg rounded-circle' alt='foto'>
        </div>
        </br>
        <div class='d-flex justify-content-center'>
            <div class='w-75 bg-white shadow lg-3 border border-3 border-primary px-5 py-2'>
                <div class='User'>
                    <h2> $name</h2>
                </div>";
        echo "<h3>Informações</h3>
                    <p>Email: $email</p>
                    <p>Telefone: $phone_user</p>
                    <p>Cep: $cep_user</p>
                    <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#exampleModal'>Atualizar</button>";

        ?>
        <!--inicio modal-->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Atualizar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="controller/emulator_user_update.php" method="post">
                            <div class="form-group">
                                <label for="phone">Celular:</label>
                                <input type="text" class="form-control" id="phone" name="phone" maxlength="13" value="<?php echo $phone_user; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <div class="form-group">
                                <label for="ConfirmPwd">Confirmar Senha:</label>
                                <input type="password" class="form-control" id="ConfirmPwd" name="ConfirmPwd" required>
                            </div>
                            <div class="form-group">
                                <label for="CEP">CEP:</label>
                                <input type="text" class="form-control" id="cep" name="cep" maxlength="9" value="<?php echo $cep_user; ?>" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <input class="btn btn-success" type="submit" value="Atualizar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        <!--fim modal-->


        <div class="d-flex justify-content-center">
            <div class="w-75 bg-white shadow lg-3 border border-3 border-primary px-5 py-2">
                <h4 class="text-center">Todos seus reports</h4>

                <?php
                //chave para o api map.
                $chave = "AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo";
                $idmap = 1;

                //definir o número total de resultados que você deseja por página
                $results_per_page = 6;

                //encontre o número total de resultados armazenados no banco de dados  
                $query = $mysql->prepare("SELECT * FROM animal_report where author_id= $id_user");
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

                //preparando querry com banco de dados, para pegar os reports feito pelo usuario
                $result = $mysql->prepare("SELECT * FROM animal_report where author_id= $id_user LIMIT " . $page_first_result . ',' . $results_per_page);
                $result->execute();
                while ($linha = $result->fetch(PDO::FETCH_ASSOC)) {
                    $id = $linha['id'];
                    $author_id = $linha['author_id'];
                    $idOngReport = $linha['ong_id'];
                    $animal = ucfirst($linha['animal_type']);
                    $description = $linha['animal_description'];
                    $situacaoReport = $linha['report_situation'];
                    $imgAnimal = $linha['animal_photo'];
                    $cep = $linha['location_cep'];
                    $location = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";
                    $imgLocation = $linha['location_photo'];
                    $pointOfReference = $linha['location_observation'];
                    $data_aceite = $linha['report_date_accepted'];
                    $situaReport = $linha['report_situation'];
                    $comments = $linha['report_comments'];
                    $imagemReport = $linha['report_img'];

                    //mudando a variavel para português
                    if ($animal == "dog") {
                        $animal = "Cachorro";
                    } else if ($animal == "cat") {
                        $animal = "Gato";
                    } else if ($animal == "others") {
                        $animal  = "Outro";
                    }

                    //se tiver reportes ira montar tabela
                    if ($number_of_result >= 1) {
                        echo "<table id='table_idsnd' class='display'>
                                <thead>
                                <tr>
                                    <th>Data reporte</th>
                                    <th>Animal</th>
                                    <th>Localização</th>
                                    <th></th>
                                </tr>
                                </thead>
                            <tbody>";
                        echo '<tr>';
                        echo '<td>' .  $ainda . '</td>';
                        echo '<td>' .  $animal  . '</td>';
                        echo '<td>' .  $location . '</td>';
                        echo "<td><a class='btn btn-success' data-toggle='modal' data-target='#Modal$id' onclick='loadmap(\"$location\",$idmap);'>Visualizar</a></td>";
                        echo '</tr>';
                        //modal
                        echo "
                            <div class='modal fade bd-example-modal-xl' id='Modal$id' tabindex='1' role='dialog' aria-labelledby='myExtraLargeModalLabel' aria-hidden='true'>
                                <div class='modal-dialog modal-xl'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='TituloModalCentralizado'>Visualizar Report</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Fechar'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <form>
                                                <!-- divs para colocar o autor, telefone e o animal em linhas até 576px -->
                                                <div class='row'>
                                                    <div class='col-sm'>
                                                        <label for='author_name' class='m-0'>
                                                            <h4>Autor</h4>
                                                        </label>
                                                        <input class='form-control w-100 mb-2' type='text' id='author_name' name='author_name' value='$name' readonly>
                                                    </div>
    
                                                    <div class='col-sm'>
                                                        <label for='animal_description' class='m-0'>
                                                            <h4>Animal</h4>
                                                        </label>
                                                        <input class='form-control w-100 mb-2' type='text' id='animal_description' name='animal_description' value='$animal' readonly>
                                                    </div>
    
                                                </div>
    
                                                <div class='form-group'>
                                                    <label for='description' class='text-md'>
                                                        <h4>Descrição</h4>
                                                    </label>
                                                    <input class='form-control w-100 mb-2' type='text' id='description' name='description' value='$description' readonly>
                                                </div>
    
                                                <!-- divs para colocar a localização e o ponto de referência em linha até 576px -->
                                                <div class='row'>
                                                    <div class='col-sm'>
                                                        <label for='localization_lastview' class='m-0'>
                                                            <h4>Localização</h4>
                                                        </label>
                                                        <input class='form-control w-100 mb-2' type='text' id='localization_lastview' name='localization_lastview' value='$location' readonly>
                                                    </div>
    
                                                    <div class='col-sm'>
                                                        <label for='localization_observation' class='m-0'>
                                                            <h4>Ponto de referência</h4>
                                                        </label>
                                                        <input class='form-control w-100 mb-2' type='text' id='localization_observation' name='localization_observation' value='$pointOfReference' readonly>
                                                    </div>
    
                                                </div>
    
                                                <!-- divs para colocar as imagens em linhas até 576px -->
                                                <div class='row'>
    
                                                    <div class='col-sm'>
                                                        <h4 class='m-0'>Foto animal</h4>
                                                        <img class='w-100 shadow border border-dark rounded ' src='./imgsUpdate/$imgAnimal'>
                                                    </div>
    
                                                    <div class='col-sm'>
                                                        <h4 class='m-0'>Foto do local</h4>
                                                        <img class='w-100 shadow border border-dark rounded' src='./imgsUpdate/$imgLocation ?>'>
                                                    </div>
    
    
                                                    <div class='col-sm'>
                                                        <h4 class='m-0'>Maps</h4>
                                                        <div class='map2 w-100 shadow border border-dark rounded' id='map$idmap'></div>
                                                    </div>
    
                                                </div>
                                            </form>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>";

                        //Fim modal
                        //cont map
                        $idmap = $idmap + 1;
                    }
                }
                //testa se usuario tem reportes
                if ($number_of_result < 1) {
                    echo "<p class='text-center'>Você ainda não realizou nenhum reporte!<a href ='reportar.php' class=''>Reporte agora!</a></p>";
                }
                ?>
                </tbody>
                </table>
                <div class="d-flex justify-content-center p-2">
                    <?php
                    //set de variaveis para paginação.
                    $pagina_anterior = $page - 1;
                    $pagina_proxima = $page + 1;
                    $page_atual = $page;

                    //Testa se pode ter o botão de pagina anterior ou não.
                    if ($pagina_anterior != 0) {
                        echo '<a href = "user_dashboard.php?page=' . $pagina_anterior . '" class="btn btn-success"> << </a>';
                    } else {
                        echo '<a href="#" class="btn btn-success disabled" role="button" aria-disabled="true"> << </a>';
                    }
                    //imprime os button de paginação até 5 (para limitar bloco de paginação).
                    for ($page = 1; $page <= 5 && $page <= $number_of_page; $page++) {
                        echo '<a href = "user_dashboard.php?page=' . $page . '" class="btn btn-success">' . $page . ' </a>';
                    }
                    /*
                    Testa se o numero de paginas vai ser maior que 5 (para limitar bloco de paginação),
                    se for ele imprime o button para a proxima pagina. 
                    */
                    if ($number_of_page > 5) {
                        if ($page_atual < $number_of_page) {
                            echo '<a href="#" class="btn btn-success disabled" role="button" aria-disabled="true">...</a>';
                            echo '<a href = "user_dashboard.php?page=' . $pagina_proxima . '" class="btn btn-success">' . $pagina_proxima . ' </a>';
                        } else {
                            echo '<a href="#" class="btn btn-success disabled" role="button" aria-disabled="true">...</a>';
                            echo '<a href = "user_dashboard.php?page=' . $page_atual . '" class="btn btn-success">' . $page_atual . ' </a>';
                        }
                    }
                    //Testa se pode ter o botão de proxima pagina ou não.
                    if ($pagina_proxima <= $number_of_page) {
                        echo '<a href = "user_dashboard.php?page=' . $pagina_proxima . '" class="btn btn-success"> >> </a>';
                    } else {
                        echo '<a href="#" class="btn btn-success disabled" role="button" aria-disabled="true"> >> </a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        </br>
    </main>
    <script src="dashboard/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="js/criar_conta.js"></script>
    <script type="text/javascript">
        var chave = "<?= $chave ?>";
    </script>
    <script src="js/user_dashboard.js"></script>"
    <script src="dashboard/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/global.js"></script>

    <?php
    //verificando se existe uma mensagem para o usúario
    if (isset($_GET['msg'])) {

        $msg = $_GET['msg']; // colocando a mensagem em uma variavel
        $_COOKIE['msg'] = $msg; // Colocando a variavel em um cookie, para conseguir pegar no outro script

        $name = $_SESSION['name']; // Colocando o nome do usúario em uma variavel 
        $_COOKIE['nome'] = $name; // Pegando a variavel e enviando para outro script via SESSION 

        include 'includes/modal.php'; //incluindo o modal para a página
    }
    //incluindo o footer na página
    require_once("includes/footer.php");
    ?>
</body>

</html>