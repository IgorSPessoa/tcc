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
                    <input type="text" id="ong_cep" name="cep" pattern= "\d{5}-?\d{3}" required>
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
                    <input type="text" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="dashboard/js/validCep.js"></script>
</body>

</html>