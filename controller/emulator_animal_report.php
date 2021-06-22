<?php
//Iniciando sessão
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if(isset($_SESSION['email']) == true){
    //Logou, então continua com as validações

}else{//Não logou então volta para a página inicial
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    session_unset();
    session_destroy();
    require_once("logout.php");
}

//conctando com o banco de dados
include "../connect.php";

//pegando as variaveis
$situacao_animal = $_POST["situacao_animal"];
$animal_descricao = $_POST["animal_descrição"];
$animal_tipo = $_POST["animal_tipo"];

//verificando se o arquivo está vazio
if (isset($_FILES['foto_animal'])){
    
    //pegando a extensão da imagem
    $separa = explode(".", $_FILES['foto_animal']['name']);
    $separa = array_reverse($separa);
    $tipoimg = $separa[0];
    $ext = strtolower("." . $tipoimg);

    // Definindo o limite do tamanho do arquivo
    $limite = 10240000;  
    
    //Definindo o tamanho em uma variavel
    $tamanhoImgAnimal = $_FILES['foto_animal']['size']; 
    
    if($tamanhoImgAnimal <= $limite){

        //definindo o nome da img como tempo e nome da ong    
        $email = $_SESSION['email'];
        $name = strstr($email, '@', TRUE);
        $id = $_SESSION['id'];
        $foto_animal = md5(time()) . $name . $id . $ext;

        //define onde a imgagem vai ser levada
        $diretorio = '../imgsUpdate/';

        //pegando nome temporario
        $tpmName = $_FILES['foto_animal']['tmp_name'];

        //Muda a localização do arquivo
        move_uploaded_file($tpmName, $diretorio . $foto_animal);
    } else{//Se o arquivo for maior que 10mb, Mmostrará um modal de erro
        header('Location: ../reportar.php?msg=invalid_size_animal&size=' . $tamanhoImgAnimal . '');
    }
}
//pegando as variaveis depois da primeira imagem
$CEP = $_POST['cep'];
$rua = $_POST['address'];
$numero = $_POST['number'];
$bairro = $_POST['district'];
$estado = $_POST['state'];
$observacao = $_POST["observacao"];

//tirando o traço do CEP
$CEP = str_replace('-', '', $CEP);

//verificando se o arquivo está vazio
if (isset($_FILES['foto_address'])){
    
    //pegando a extensão da imagem
    $separa = explode(".", $_FILES['foto_address']['name']);
    $separa = array_reverse($separa);
    $tipoimg = $separa[0];
    $ext = strtolower("." . $tipoimg);

    // Definindo o limite do tamanho do arquivo
    $limite = 10240000; 
    
    //Definindo o tamanho em uma variavel
    $tamanhoImgLocation = $_FILES['foto_address']['size']; 
    
    if($tamanhoImgLocation <= $limite){
        //definindo o nome da img como tempo e nome da ong    
        $foto_address = md5(time()) . $id  . $name . $ext;

        //define onde a imgagem vai ser levada
        $diretorio = '../imgsUpdate/';

        //pegando nome temporario
        $tpmName = $_FILES['foto_address']['tmp_name'];

        //Mudar a localização do arquivo
        move_uploaded_file($tpmName, $diretorio . $foto_address);
    } else{//Se o arquivo for maior que 10mb
        header('Location: ../reportar.php?msg=invalid_size_location&size=' . $tamanhoImgLocation . '');
    }
}

//query de criação do endereço da ong
$sql = " INSERT INTO address
                         (location_cep,
                         location_address,
                         location_number,
                         location_district,
                         location_state,
                         location_photo, 
                         location_observation)
                    VALUES 
                         (?, ?, ?, ?, ?, ?, ?);";

//preparando a query                      
$query = $mysql->prepare($sql);

//executando a querry com as variaveis necessárias
$query->execute([$CEP, $rua, $numero, $bairro, $estado, $foto_address, $observacao]);

//pengando o id do cadastro de cep e salvando em uma variavel 
$LAST_ID = $mysql->lastInsertId();


//linha de comando que irá ser chamada no bd
$sqlSnd =" INSERT INTO animal_report 
                     (author_id,
                     address_id, 
                     animal_type, 
                     animal_description, 
                     animal_situation,
                     animal_photo, 
                     report_created_data,
                     report_date_accepted,
                     report_situation,
                     report_comments,
                     report_img) 
                VALUES 
                     (?,?,?,?,?,?, CURRENT_DATE(),?,?,?,?);";

//variaveis invisiveis
$reportAceito = "0000-00-00";
$report_situacao = "pending";
$report_comentario = "";
$report_img = "";

//preparando para executar
$stmt = $mysql->prepare($sqlSnd);

// executando a query
$stmt->execute([$id, $LAST_ID, $animal_tipo, $animal_descricao, $situacao_animal, $foto_animal, $reportAceito, $report_situacao, $report_comentario, $report_img]);

//verificando se os dois resultados deram verdadeiros (true)
if($query && $stmt){//caso sim, irá cair aqui
    header('Location: ../reportar.php?msg=sucess_report');
}else{//caso não, irá cair aqui
    header('Location: ../reportar.php?msg=error_report');   
}
?>