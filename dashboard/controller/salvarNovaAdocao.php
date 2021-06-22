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

//Conectando com o servidor mysql
include '../../connect.php';

//Pegando o id da ong logada
$id = $_SESSION['id'];

//Declarando os nomes das variáveis pegas no NovaAdocao
$animal_name = "$_POST[animal_name]";
$animal_description = "$_POST[animal_description]";
$animal_race = "$_POST[animal_race]";
$animal_weight = "$_POST[animal_weight]";
$animal_category = "$_POST[animal_category]";
$animal_gender = "$_POST[animal_gender]";
$animal_type = "$_POST[animal_type]";
$animal_age = "$_POST[animal_age]";
$animal_ong_since = "$_POST[animal_ong_since]";
$animal_situation = 'waiting';

//verificando se o arquivo está vazio
if (isset($_FILES['arquivo'])){
    //pegando a extensão da imagem
    $separa = explode(".", $_FILES['arquivo']['name']);
    $separa = array_reverse($separa);
    $tipoimg = $separa[0];
    $ext = strtolower("." . $tipoimg);
    
    // Definindo o limite do tamanho do arquivo
    $limite = 10240000; 
    
    //Definindo o tamanho em uma variavel
    $tamanhoImg = $_FILES['arquivo']['size']; 
    if($tamanhoImg <= $limite){
        //pegando o nome da ong
        $email = $_SESSION['email'];
        $nameOng = strstr($email, '@', TRUE);

        //definindo o nome da img como tempo e nome da ong    
        $nomeImg = time() . md5($nameOng) . $ext;

        //define onde a imgagem vai ser levada
        $diretorio = '../../imgsUpdate/';

        //pegando nome temporario
        $tpmName = $_FILES['arquivo']['tmp_name'];

        //Mudar a localização do arquivo junto com o arquivo
        move_uploaded_file($tpmName, $diretorio . $nomeImg);

    }else{//Se o arquivo for maior que 10mb
        header('Location: ../novaAdocao.php?msg=invalid_size_animal&size=' . $tamanhoImg . '');
    }
}

//Pegando os dados enviados para o mysql
$sql = "INSERT INTO `tcc`.`animal_adoption` (`ong_id`,  `animal_name`, `animal_description`, `animal_type`, `animal_age`, `animal_gender`, `animal_ong_since`, `animal_photo`, `animal_race`, `animal_weight`, `animal_category`, `adoption_situation`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
$stmt = $mysql->prepare($sql);

//executando a query que insere no banco de dados
$stmt->execute([$id, $animal_name, $animal_description, $animal_type, $animal_age, $animal_gender, $animal_ong_since, $nomeImg, $animal_race, $animal_weight, $animal_category, $animal_situation]);

//verificando se o resultado da query for verdadeiro
if($stmt){ //Se sim, cairá aqui
    header("location: ../adocoes.php?msg=sucess_adoption");
}else{//Se não, cairá aqui
    header("location: ../adocoes.php?msg=error_adoption");
}

?>