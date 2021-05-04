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
    <link rel="stylesheet" href="css/adocao.css">


    <title>Adoção</title>
</head>

<body>
    <h1 class="text-center">Encontre animais para adotar!</h1>
    <main class="p-3">
        <div class="animals">
            <?php
            include "connect.php";

            //definir o número total de resultados que você deseja por página
            $results_per_page = 9;

            //encontre o número total de resultados armazenados no banco de dados  
            $query = $mysql->prepare("SELECT * FROM animal_adoption;");
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
            $query = $mysql->prepare("SELECT * FROM animal_adoption LIMIT " . $page_first_result . ',' . $results_per_page);
            $query->execute();

            //exibir o resultado recuperado na página da web 
            //while ($row = mysqli_fetch_array($result))
            while ($linha = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='animal bg-white shadow lg-3 border border-3 border-primary px-5 py-2'>
                        <span>" . $linha['name'] . "</span>
                    
                        <img src='imgs/" . $linha['img'] . "' alt='Imagem de um cachorro'>
                        <br><br>
                        <a href='animal_profile.php?id=" . $linha['id'] . "' class='button'>Visualizar informações</a>
                        <br><br>
                    </div>";
            }
            for ($page = 1; $page <= $number_of_page; $page++) {
                echo '<a href = "adocao.php?page=' . $page . '" class="button">' . $page . ' </a>';
            }
            /*
            $dados = $mysql->prepare("SELECT name, description, img, id FROM animal_adoption");
            $dados->execute();
            while ($linha = $dados->fetch(PDO::FETCH_ASSOC)) {
                //var_dump($linha);
                //<p>$linha[1]</p> vai depois do linha 0.
                echo "<div class='animal bg-white shadow lg-3 border border-3 border-primary px-5 py-2'>
                        <span>" . $linha['name'] . "</span>
                    
                        <img src='imgs/" . $linha['img'] . "' alt='Imagem de um cachorro'>
                        <br><br>
                        <a href='animal_profile.php?id=" . $linha['id'] . "' class='button'>Visualizar informações</a>
                        <br><br>
                    </div>";
            }*/
            ?>
        </div>
    </main>

    <?php
    require_once("includes/footer.php");
    ?>
</body>

</html>