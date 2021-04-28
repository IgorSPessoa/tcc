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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="css/resetcss.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/responsiveToBoot.css">


    <title>Criar conta Ong</title>
</head>

<body class="bg-light">
    <?php
    require_once("includes/nav.php");
    ?>
    <main class="p-5">
        <form class="bg-white shadow lg-3 border border-3 border-dark px-5 py-5" action="controller/emulator_create_account.php" method="post">
            <div class="border border-4 border-secondary rounded">
                <fieldset>
                    <div class="text-center">
                        <h2>Crie uma conta para sua ONG</h2>
                        <p>Preencha os dados solicitados, após isso vamos avaliar sua conta e entrar em contato por e-mail em até 3 dias úteis.</p>
                    </div>
                    <label for="ong_name">Nome da ONG:</label>
                    <input type="text" id="ong_name" name="ong_name" required>
                    <label for="ong_description">Descrição da ONG:</label>
                    <input type="text" id="ong_description" name="ong_description" required>
                    <label for="ong_address">Endereço da ONG:</label>
                    <input type="text" id="ong_address" name="ong_address" required>
                    <label for="ong_cep">CEP da ONG:</label>
                    <input type="number" id="ong_cep" name="ong_cep" required>
                    <br>
                </fieldset>
            </div>

            <div class="border border-4 border-secondary rounded mt-4">
                <fieldset>
                    <div class="text-center">
                        <h2>Acesso da ONG</h2>
                        <p>Você vai usar estes dados para ter acesso ao painel de controle.</p><br>
                    </div>
                    <label for="email">E-mail</label>
                    <input type="text" id="email" name="email" required>
                    <label for="senha">Senha</label>
                    <input type="text" id="senha" name="senha" required>
                    <small><a href="login.php">Já tem uma conta? Faça login</a></small>

                    <br>
                    <input type="hidden" name="acc_type" value="ong">
                    <input class="btn btn-primary mb-3 w-100 " type="submit" value="Criar conta">
                    <br>
                </fieldset>
            </div>
            <div class="links pt-3">
                <h6>Já tem uma conta? <a class="text-primary" href="login.php">Faça login</a></h6><br>
            </div>
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