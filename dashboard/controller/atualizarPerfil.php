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

//pegando o id da ong 
$id = $_SESSION['id'];

//pegando os dados do forms
$proposito = "$_POST[reason]";
$horarioFunc = "$_POST[opening_hours]";
$telefone = "$_POST[phone]";
$descricao = "$_POST[description]";
$CEP = "$_POST[cep]";
$rua = "$_POST[address]";
$numero = "$_POST[number]";
$bairro = "$_POST[district]";
$estado = "$_POST[state]";

//Colocando o estado(por escrito) no $estado, pois no VIACEP não está disponibilizado esta função (apenas em o UF)
if($estado == "AC"){
    $estado = "Acre";
} elseif($estado == "AL"){
    $estado = "Alagoas";
} elseif($estado == "AP"){
    $estado = "Amapá";
} elseif($estado == "AM"){
    $estado = "Amazonas";
} elseif($estado == "BA"){
    $estado = "Bahia";
} elseif($estado == "CE"){
    $estado = "Ceará";
} elseif($estado == "DF"){
    $estado = "Distrito Federal";
} elseif($estado == "ES"){
    $estado = "Espírito Santo";
} elseif($estado == "GO"){
    $estado = "Goiás";
} elseif($estado == "MA"){
    $estado = "Maranhão";
} elseif($estado == "MT"){
    $estado = "Mato Grosso";
} elseif($estado == "MS"){
    $estado = "Mato Grosso do Sul";
} elseif($estado == "MG"){
    $estado = "Minas Gerais";
} elseif($estado == "PA"){
    $estado = "Pará";
} elseif($estado == "PB"){
    $estado = "Paraíba";
} elseif($estado == "PR"){
    $estado = "Paraná";
} elseif($estado == "PE"){
    $estado = "Pernambuco";
} elseif($estado == "PI"){
    $estado = "Piauí";
} elseif($estado == "RJ"){
    $estado = "Rio de Janeiro";
} elseif($estado == "RN"){
    $estado = "Rio Grande do Norte";
} elseif($estado == "RS"){
    $estado = "Rio Grande do Sul";
} elseif($estado == "RO"){
    $estado = "Rondônia";
} elseif($estado == "RR"){
    $estado = "Roraima";
} elseif($estado == "SC"){
    $estado = "Santa Catarina";
} elseif($estado == "SP"){
    $estado = "São Paulo";
} elseif($estado == "SE"){
    $estado = "Sergipe";
} elseif($estado == "TO"){
    $estado = "Tocantins";
}

//Se houver um novo avatar enviado, delete o antigo e atualize um novo
if($_FILES['arquivo']['name'] != ""){
    //pegando a extensão da imagem
    $separa = explode(".", $_FILES['arquivo']['name']);
    $separa = array_reverse($separa);
    $tipoimg = $separa[0];
    $ext = strtolower("." . $tipoimg);
    
    if($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png' || $ext == '.svg'){
        // Definindo o limite do tamanho do arquivo
        $limite = 10240000; 
        
        //Definindo o tamanho em uma variavel
        $tamanhoImg = $_FILES['arquivo']['size']; 
        
        if($tamanhoImg <= $limite){
            //pegando o nome da imgagem no Banco de dados
            $img = $mysql->prepare("SELECT ong_img FROM ong WHERE id = $id");
            $img->execute();

            //verificando se existe uma imagem no bd
            if($linha = $img->fetch(PDO::FETCH_ASSOC)){
                $name = $linha['ong_img']; //Se existir vai entrar na variavel $name
            }

            if(file_exists("../../imgs/$name")) { //verificando se ela existe no diretorio
                unlink("../../imgs/$name"); //Tirando a imgagem do diretorio
            } 

            //diretorio
            $uploaddir = "../../imgs/";

            //pegando o nome da ong
            $email = $_SESSION['email'];
            $nameOng = strstr($email, '@', TRUE);

            //definindo onovo nome da imagem como tempo e nome da ong    
            $newNameImg = md5($nameOng) . time() . $ext;

            //Upando a imagem no repositorio
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploaddir . $newNameImg);

            //tirando traço do cep
            $CEPAlterado = str_replace('-', '', $CEP);

            //query para atualizar a imagem do bd
            $sql = "UPDATE ong 
                      SET ong_description = ?,
                      ong_purpose = ?,
                      ong_phone = ?,
                      ong_business_hours = ?,
                      location_cep = ?,
                      location_address = ?,
                      location_number = ?,
                      location_district = ?,
                      location_state = ?,
                      ong_img = ? 
                        WHERE id = ?";
            $stmt = $mysql->prepare($sql);
            
            //executar o update
            $stmt->execute([$descricao, $proposito, $telefone, $horarioFunc, $CEPAlterado, $rua, $numero, $bairro, $estado, $newNameImg, $id]);
            
            if($stmt){
                echo "<script language='javascript' type='text/javascript'>alert('Atualização feita com sucesso!'); window.location = ' ../perfil.php'; </script>";
            }else{
                echo "<script language='javascript' type='text/javascript'>alert('Não foi possivel fazer a atualização da adoção!'); window.location = ' ../perfil.php';</script>";
            }
        } else {
            echo "<script language='javascript' type='text/javascript'>alert('Arquivo muito grande, o tamanho máximo do arquivo é 10MB. Tamanho do arquivo atual: $tamanhoImg'); window.location = ' ../perfil.php';</script>";
        }  
    } else {
        echo "<script language='javascript' type='text/javascript'>alert('O arquivo não é uma imagem, por favor faça o upload de uma imagem .png, .jpg ou .svg . Extensão atual: $ext'); window.location = ' ../perfil.php';</script>";
    }
} elseif($_FILES['arquivo']['error'] == '4'){
    $CEPAlterado = str_replace('-', '',$CEP);
    $sql = "UPDATE ong 
              SET ong_description = ?,
              ong_purpose = ?,
              ong_phone = ?,
              ong_business_hours = ?,
              location_cep = ?,
              location_address = ?,
              location_number = ?,
              location_district = ?,
              location_state = ? 
                WHERE id = ?";
    $stmt = $mysql->prepare($sql);

    $stmt->execute([$descricao, $proposito, $telefone, $horarioFunc, $CEPAlterado, $rua, $numero, $bairro, $estado, $id]);
    
    if($stmt){
        echo "<script language='javascript' type='text/javascript'>alert('Atualização feita com sucesso!'); window.location = ' ../perfil.php';</script>";
    }else{
        echo "<script language='javascript' type='text/javascript'>alert('Não foi possivel fazer a atualização da adoção!'); window.location = ' ../perfil.php';</script>";
    }
}

