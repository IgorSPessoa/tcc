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
    <link rel="stylesheet" href="css/responsiveToBoot.css">

    <title>Criar conta</title>
</head>

<body class="bg-light">
    <?php
    require_once("includes/nav.php");
    ?>
    <main class="p-5">
        <form class="bg-white shadow lg-3 border border-3 border-secondary px-5 py-5" action="controller/emulator_create_account.php" method="post">
            <fieldset>
                <h2>Crie uma conta</h2>
                <label for="name">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" required>
                <label for="senha">Senha:</label>
                <input type="text" id="senha" name="senha" required>

                <br>
                <input type="hidden" name="acc_type" value="user">
                <input class="btn btn-primary mb-3 w-100 " type="submit" value="Criar conta">

                <div class="links">
                    Já tem uma conta? <a class="text-primary" href="login.php">Faça login</a><br>
                    Tem uma ONG? <a class="text-primary" href="criar_conta_ong.php">Crie uma conta para ONGS aqui!</a>
                </div>
            </fieldset>
        </form>
    </main>
    <?php
    require_once("includes/footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>