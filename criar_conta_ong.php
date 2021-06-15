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
    <link rel="stylesheet" href="css/criar_conta_ong.css">


    <title>Criar conta Ong</title>
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
    
    <main class="p-5">
        <form style="box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;" class="bg-white shadow lg-3 border border-3 border-dark px-5 py-5" action="controller/emulator_create_account.php" method="post">
            <div class="border border-4 border-secondary rounded">
                <fieldset>
                    <div class="text-center">
                        <h2>Crie uma conta para sua ONG</h2>
                        <p>Preencha os dados solicitados, após isso vamos avaliar sua conta e entrar em contato por e-mail em até 3 dias úteis.</p>
                    </div>

                    <label for="ong_name">Nome da ONG:</label>
                    <input type="text" class="form-control" id="ong_name" name="ong_name" maxlength="50" required>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first">Data de abertura:</label>
                                <input type="date" style="border-radius: 8px;" class="form-control mb-2" id="opening_date" maxlength="300" name="opening_date" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                            <label for="opening_hours">Horário de funcionamento:</label>
                            <input type="text" class="form-control" id="opening_hours" name="opening_hours" required>   
                    </div>   

                    <label for="ong_description">Descrição da ONG:</label>
                    <textarea class="form-control" id="ong_description" name="ong_description" rows="3" maxlength="300" required></textarea>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ong_reason">Propósito:</label>
                                <select style="border-radius: 8px;" class="form-control mt-1"  id="ong_reason" name="ong_reason" required>
                                    <option value="" selected disabled hidden>Selecione</option>
                                    <option value="acolher_animal">Acolher animais</option>
                                    <option value="socorro_animal">Socorro Animal</option>
                                    <option value="alimentacao_animal">Alimentação Animal</option>
                                    <option value="adocao_animal">Adoção Animal</option>
                                    <option value="outros">Outros</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="phone">Telefone:</label>
                            <input class="form-control mt-0" type="text" id="phone" name="phone" required>
                        </div>
                    </div> 

                    <label for="ong_cep">CEP da ONG:</label>
                    <input type="text" class="form-control" id="ong_cep" name="ong_cep" onblur="pesquisacep(this.value);" pattern= "\d{5}-?\d{3}" required>
                    
                    <div class="row ">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="ong_address">Endereço da ONG:</label>
                                <input type="text" class="form-control" id="ong_address" name="ong_address" maxlength="150" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ong_number">N°:</label>
                                <input type="text" class="form-control" id="ong_number" name="ong_number" maxlength="50" required>
                            </div>
                        </div>
                    </div>    

                    <div class="row ">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ong_district">Bairro:</label>
                                <input type="text" class="form-control" id="ong_district" name="ong_district" maxlength="50" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ong_state">Estado:</label>
                                <input type="text" class="form-control" id="ong_state" name="ong_state" maxlength="50" required>
                            </div>
                        </div>
                    </div>    

                    <br>
                </fieldset>
            </div>

            <div class="border border-4 border-secondary rounded mt-4">
                <fieldset>
                    <div class="text-center">
                        <h2>Acesso da ONG</h2>
                        <p>Você vai usar estes dados para ter acesso ao painel de controle.</p><br>
                    </div>
                    <label for="email">E-mail:</label>
                    <input type="text" class="form-control" id="email" name="email" maxlength="100" pattern="[aA-zZ0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>

                    <label for="senha">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" maxlength="200" required>

                    <label for="ConfirmPwd">Confirmar Senha:</label>
                    <input type="password" class="form-control" id="ConfirmPwd" name="ConfirmPwd" maxlength="200" required>

                    <br>
                    <input type="hidden" name="acc_type" value="ong">
                    <input class="btn btn-primary mb-3 w-100 " type="submit" value="Criar conta">
                    <br>
                </fieldset>
            </div>
            <div class="links pt-3">
                <p>Já tem uma conta? <a class="text-primary" href="login.php">Faça login</a></p>
            </div>
        </form>
    </main>
    <script src="dashboard/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="dashboard/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/criar_conta_ong.js"></script>
    <script src="js/global.js"></script>
    <?php
    //colocando o footer na página
    require_once("includes/footer.php");

   //verificando se existe uma mensagem na URL da página
   if (isset($_GET['msg'])) {//Se existe ele cairá neste if, se não, continuará a operação normalmente
        $msg = $_GET['msg'];// Colocando a mensagem em uma variável
        $_COOKIE['msg'] = $msg; // Colocando ela em cookie para conseguir pegar em outro script
    }
    // Precisa ficar aqui embaixo para verificar o cookie
    include 'includes/modal.php';
    ?>
</body>

</html>