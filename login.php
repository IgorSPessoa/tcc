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
    <link rel="stylesheet" href="css/responsiveToBoot.css">
    <title>Login</title>
</head>

<body>
    <?php
    require_once("includes/nav.php");
    ?>
    <main class="p-5">
        <form style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;" class="bg-white shadow lg-3 border border-3 border-primary px-5 py-5" action="controller/emulator_login.php" method="post">

            <h2>Fazer login</h2>
            <div class="input-block">
                <label for="email">E-mail</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="input-block">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>

            <br>
            <input class="btn btn-primary mb-3 w-100" type="submit" value="Fazer login">
            <br>
            <div class="links">
                Não tem uma conta? <a class="text-primary" href="criar_conta.php">Crie aqui</a><br>
                Tem uma ONG? <a class="text-primary" href="criar_conta_ong.php">Crie uma conta para ONGS aqui!</a>
            </div>
        </form>
    </main>
    <script src="dashboard/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="dashboard/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/global.js"></script>
    <?php
    //Colocando o footer na página
    require_once("includes/footer.php");

    //verificando se existe uma mensagem na URL da página
    if (isset($_GET['msg'])) {//Se existe ele cairá neste if, se não, continuará a operação normalmente

        $msg = $_GET['msg'];// Colocando a mensagem em uma variável
        $_COOKIE['msg'] = $msg; // Colocando ela em cookie para conseguir pegar em outro script

         //incluindo o modal para a página
        include 'includes/modal.php';
    }
    ?>
</body>

</html>
