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
    <link rel="stylesheet" href="css/ongs.css">
    <title>Ongs</title>
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
    <h1 class="text-center">Lista de Ongs</h1>
    <main class="p-3">
        <div class="animals">
            <?php
            include "connect.php";

            //definir o número total de resultados que você deseja por página
            $results_per_page = 9;

            //encontre o número total de resultados armazenados no banco de dados  
            $query = $mysql->prepare("SELECT * FROM ong;");
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

            //recuperar os resultados selecionados do banco de dados   
            //$query = "SELECT *FROM alphabet LIMIT " . $page_first_result . ',' . $results_per_page;   
            //$query = "SELECT * FROM animal_adoption LIMIT " . $page_first_result . ',' . $results_per_page;
            $query = $mysql->prepare("SELECT * FROM ong LIMIT " . $page_first_result . ',' . $results_per_page);
            $query->execute();

            //exibir o resultado recuperado na página da web 
            //while ($row = mysqli_fetch_array($result))
            while ($linha = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='animal bg-white shadow lg-3 border border-3 border-primary px-5 py-2'>
                            <span class='text-center'>" . $linha['ong_name'] . "</span>
                            
                            <img src='imgsUpdate/" . $linha['ong_img'] . "' alt='Imagem da ong'>
                            <br><br>
                            <a href='ong_profile.php?id=" . $linha['id'] . "' class='button'>Visualizar perfil</a>
                            <br><br>
                        </div>";
            }
            ?>
        </div>
        </br>
        <div class="d-flex justify-content-center">
            <?php
            //set de variaveis para paginação.
            $pagina_anterior = $page - 1;
            $pagina_proxima = $page + 1;
            $page_atual = $page;

            //Testa se pode ter o botão de pagina anterior ou não.
            if ($pagina_anterior != 0) {
                echo '<a href = "ongs.php?page=' . $pagina_anterior . '" class="btn button text-center"> << </a>';
            } else {
                echo '<a href="#" class="btn button disabled" role="button" aria-disabled="true"> << </a>';
            }
            //imprime os button de paginação até 5 (para limitar bloco de paginação).
            for ($page = 1; $page <= 5 && $page <= $number_of_page; $page++) {
                echo '<a href = "ongs.php?page=' . $page . '" class="button text-center">' . $page . ' </a>';
            }
            /*
            Testa se o numero de paginas vai ser maior que 5 (para limitar bloco de paginação),
            se for ele imprime o button para a proxima pagina. 
            */
            if ($number_of_page > 5) {
                if ($page_atual < $number_of_page) {
                    echo '<a href="#" class="btn button disabled" role="button" aria-disabled="true">...</a>';
                    echo '<a href = "ongs.php?page=' . $pagina_proxima . '" class="button text-center">' . $pagina_proxima . ' </a>';
                } else {
                    echo '<a href="#" class="btn button disabled" role="button" aria-disabled="true">...</a>';
                    echo '<a href = "ongs.php?page=' . $page_atual . '" class="button text-center">' . $page_atual . ' </a>';
                }
            }
            //Testa se pode ter o botão de proxima pagina ou não.
            if ($pagina_proxima <= $number_of_page) {
                echo '<a href = "ongs.php?page=' . $pagina_proxima . '" class="btn button text-center"> >> </a>';
            } else {
                echo '<a href="#" class="btn button disabled" role="button" aria-disabled="true"> >> </a>';
            }
            ?>
        </div>
        </br>
    </main>
    <?php
    //incluindo o footer da página
    require_once("includes/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/global.js"></script>
    <?php
        //verificando se existe uma mensagem na URL da página
        if(isset($_GET['msg'])) {//Se existe ele cairá neste if, se não, continuará a operação normalmente
            $msg = $_GET['msg'];// Colocando a mensagem em uma variável
            $_COOKIE['msg'] = $msg; // Colocando ela em cookie para conseguir pegar em outro script

            include 'includes/modal.php';
        }
    ?>
</body>

</html>
