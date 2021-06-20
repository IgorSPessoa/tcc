<?php
//Iniciando sessão
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (isset($_SESSION['email']) == true) {
    //Logou, então continua com as validações

} else { //Não logou então volta para a página inicial
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    session_unset();
    session_destroy();
    require_once("logout.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css_dashboard/all.css">
    <link rel="stylesheet" href="css_dashboard/adocoes.css">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <title>Companheiro Fiel - Adoções</title>
</head>

<body>
    <div class="flex-dashboard">
        <!-- Includindo a barra lateral -->
        <?php include "includes/sidebar.php"; ?>

        <main>
            <!-- Incluindo o cabeçalho do site -->
            <?php include "includes/header.php"; ?>
            <div class="main-content">
                <?php
                // Conectando com o banco de dados
                include '../connect.php';

                // Declarando variáveis
                $id = $_GET['id'];

                // Pegando conteúdo do banco de dados e colocando na variavel
                $sql = $mysql->prepare("SELECT * FROM animal_adoption WHERE id = $id");
                $sql->execute();
                
                //conta quantas linhas foram recebidas pelo banco de dados
                $count = $sql->rowCount();
                if ($count < 1) {
                    header('Location: ./index.php?msg=error_information');
                }

                //verficando se houve resultado para na query
                $rows = $sql->rowCount();

                if ($rows >= 1) { // se existe algum resultado, irá pegar os dados 
                    while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $name = $linha['animal_name'];
                        $description = $linha['animal_description'];
                        $animal = $linha['animal_type'];
                        $idade = $linha['animal_age'];
                        $sexo = $linha['animal_gender'];
                        $data_chegada = $linha['animal_ong_since'];
                        $img = $linha['animal_photo'];
                        $raca = $linha['animal_race'];
                        $peso = $linha['animal_weight'];
                        $categoria = $linha['animal_category'];
                        $situacao = $linha['adoption_situation'];
                    }
                } else { //Se não tiver resultados, irá aparecer um modal de error para o usuário
                    header('Location: adocoes.php?msg=error_information');
                }
                ?>
                <form action="controller/updateAdocao.php" method="POST" enctype="multipart/form-data" runat="server" novalidate>
                    <div class="form-group mb-4">
                        <label for="animal_name" class="mb-1">
                            <h4>Nome:</h4>
                        </label>
                        <input class="form-control w-100" type="text" id="animal_name" name="animal_name" value='<?php echo $name; ?>' autocomplete="off" maxlength="50" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-9 mb-3">
                            <label for="animal_description" class="text-md">
                                <h4>Descrição do Animal:</h4>
                            </label>
                            <textarea class="form-control " id="animal_description" name="animal_description" rows="2" maxlength="200" required><?php echo $description; ?></textarea>
                        </div>

                        <div class="col-md-3">
                            <label for="animal_status" class="text-md ">
                                <h4>Estado da adoção:</h4>
                            </label>
                            <select class="form-control" id="animal_status" name="animal_status">
                                <option value="waiting" <?php if ($situacao == "waiting") {
                                                            echo "selected";
                                                        } ?>>Aguardando</option>
                                <option value="scheduled" <?php if ($situacao == "scheduled") {
                                                                echo "selected";
                                                            } ?>>Agendado</option>
                                <option value="adopted" <?php if ($situacao == "adopted") {
                                                            echo "selected";
                                                        } ?>>Adotado</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <label for="animal_race" class="text-md">
                                <h4>Raça:</h4>
                            </label>
                            <input type="text" class="form-control" name="animal_race" id="animal_race" value='<?php echo $raca; ?>' autocomplete="off" maxlength="50" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="animal_weight" class="text-md">
                                <h4>Peso:</h4>
                            </label>
                            <input type="text" class="form-control" name="animal_weight" id="animal_weight" value='<?php echo $peso; ?>' autocomplete="off" maxlength="50" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="animal_category" class="text-md">
                                <h4>Porte:</h4>
                            </label>
                            <select class="form-control" id="animal_category" name="animal_category">
                                <option value="small" <?php if ($categoria == "small") {
                                                            echo "selected";
                                                        } ?>>Pequeno</option>
                                <option value="average" <?php if ($categoria == "average") {
                                                            echo "selected";
                                                        } ?>>Médio</option>
                                <option value="big" <?php if ($categoria == "big") {
                                                        echo "selected";
                                                    } ?>>Grande</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="animal_gender" class="text-md">
                                <h4>Sexo</h4>
                            </label>
                            <select class="form-control" id="animal_gender" name="animal_gender" value='<?php echo $sexo; ?>'>
                                <option value="male" <?php if ($sexo == "male") {
                                                            echo "selected";
                                                        } ?>>Macho</option>
                                <option value="female" <?php if ($sexo == "female") {
                                                            echo "selected";
                                                        } ?>>Fêmea </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label for="animal_type" class="text-md">
                                <h4>Animal:</h4>
                            </label>
                            <select class="form-control" id="animal_type" name="animal_type">
                                <option value="dog" <?php if ($animal == "dog") {
                                                        echo "selected";
                                                    } ?>>Cachorro</option>
                                <option value="cat" <?php if ($animal == "cat") {
                                                        echo "selected";
                                                    } ?>>Gato</option>
                                <option value="others" <?php if ($animal == "others") {
                                                            echo "selected";
                                                        } ?>>Outros</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="animal_age" class="text-md">
                                <h4>Idade:</h4>
                            </label>
                            <input type="text" class="form-control" name="animal_age" id="animal_age" value='<?php echo $idade; ?>' autocomplete="off" maxlength="30">
                            <small>Não obrigatório</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="animal_ong_since" class="text-md">
                                <h4>Na Ong Desde:</h4>
                            </label>
                            <input type="date" class="form-control" name="animal_ong_since" id="animal_ong_since" value='<?php echo $data_chegada; ?>' required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 container_images">
                            <h4>Foto do animal:<a id="imgInput" onclick="click_the_button(arquivo);" class="inputButton"><i id="upload" class="far fa-arrow-alt-circle-up"></i></a></h4>
                            <img src="<?php echo "../imgsUpdate/$img"; ?>" id="animalView">
                            <div class="mb-2">
                                <input type="file" name="arquivo" id="arquivo" onchange="loadFile(event)" accept="image/png, image/jpeg" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <a class="btn btn-dark w-100 mb-2" type="button" href="adocoes.php">Voltar</a>
                        </div>

                        <div class="col-sm">
                            <input class="btn btn-warning text-light w-100 mb-2" type="reset" value="Apagar">
                        </div>

                        <div class="col-sm">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input class="btn btn-success w-100 mb-2" type="submit" value="Atualizar">
                        </div>
                    </div>
                </form>
                <?php
                //Incluindo o footer da página
                include "includes/footer.php";
                ?>
            </div>
        </main>
    </div>

    <script src="js/global.js"></script>
    <script src="plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="plugins/fontawesome/js/fontawesome.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/editarAdocao.js"></script>
    <?php
    //Verificar se existe uma mensagem para abrir um modal
    if (isset($_GET['msg'])) { //Verificando se existe mensagem
        $msg = $_GET['msg']; //pegando a mensagem
        $_COOKIE['msg'] = $msg; //Transformando ela em cookie para enviar para outro script

        if ($msg == "invalid_size_animal") { //verficiando se a msg deu como tamanho da imagem do animal invalida 
            $tamanho = $_GET['size'];
            $_COOKIE['size'] = $tamanho;
        }
        include '../includes/modal.php'; //incluindo o modal para a página
    }
    ?>
</body>

</html>