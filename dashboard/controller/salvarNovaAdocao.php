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

//Concetando com o servidor mysql
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

//verificando se o arquivo está vazio
if (isset($_FILES['arquivo'])){
    //pegando a extensão da imagem
    $separa = explode(".", $_FILES['arquivo']['name']);
    $separa = array_reverse($separa);
    $tipoimg = $separa[0];
    $ext = strtolower("." . $tipoimg);


    if($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png' || $ext == '.svg'){ //Verificando se o arquivo é uma img
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
            $diretorio = '../../imgs/';

            //pegando nome temporario
            $tpmName = $_FILES['arquivo']['tmp_name'];

            //Mudar a localização do arquivo
            move_uploaded_file($tpmName, $diretorio . $nomeImg);
    
        }else{//Se o arquivo for maior que 10mb
            echo "<script language='javascript' type='text/javascript'>alert('Arquivo muito grande, o tamanho máximo do arquivo é 10MB. Tamanho do arquivo atual: $tamanhoImg'); window.location = ' ../novaAdocao.php';</script>";
        }
    }else{//se o arquivo não tiver a extensão desejada
        echo "<script language='javascript' type='text/javascript'>alert('O arquivo não é uma imagem, por favor faça o upload de uma imagem .png, .jpg ou .svg . Extensão atual: $ext'); window.location = ' ../novaAdocao.php';</script>";
    }
}

//Pegando os dados enviados para o mysql
$sql = "INSERT INTO `tcc`.`animal_adoption` (`ong_id`,  `animal_name`, `animal_description`, `animal_type`, `animal_age`, `animal_gender`, `animal_ong_since`, `animal_photo`, `animal_race`, `animal_weight`, `animal_category`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

$stmt = $mysql->prepare($sql);

echo $nomeImg;

//fazendo a inserção no banco de dados
$stmt->execute([$id, $animal_name, $animal_description, $animal_type, $animal_age, $animal_gender, $animal_ong_since, $nomeImg, $animal_race, $animal_weight, $animal_category]);
if($stmt){
    echo "<script language='javascript' type='text/javascript'>alert('Adoção cadastrada com sucesso!'); window.location = ' ../adocoes.php';</script>";
}else{
    echo "<script language='javascript' type='text/javascript'>alert('Não foi possivel fazer o cadastro da adoção!'); window.location = ' ../novaAdocao.php';</script>";
}

?>