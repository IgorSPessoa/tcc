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

//pegando o id da ong 
$id = $_SESSION['id'];

//pegando os dados do formulario, e colocando nas variaveis
$proposito = "$_POST[reason]";
$horarioFunc = "$_POST[opening_hours]";
$telefone = "$_POST[phone]";
$descricao = "$_POST[description]";
$whatsapp = "$_POST[whatsapp]";
$facebook = "$_POST[url_facebook]";
$CEP = "$_POST[cep]";
$rua = "$_POST[address]";
$numero = "$_POST[number]";
$bairro = "$_POST[district]";
$estado = "$_POST[state]";
$address_id = "$_SESSION[address_id]";

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
        if($name != "default_avatar.jpg"){
            if(file_exists("../../imgsUpdate/$name")) { //verificando se ela existe no diretorio
                unlink("../../imgsUpdate/$name"); //Tirando a imgagem do diretorio
            } 
        }
        
        //diretorio
        $uploaddir = "../../imgsUpdate/";

        //pegando o nome da ong
        $email = $_SESSION['email'];
        $nameOng = strstr($email, '@', TRUE);

        //definindo onovo nome da imagem como tempo e nome da ong    
        $newNameImg = md5($nameOng) . time() . $ext;

        //Upando a imagem no repositorio
        move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploaddir . $newNameImg);

        //tirando o traço do CEP
        $CEPAlterado = str_replace('-', '', $CEP);

        //tirando parenteses e o traço do telefone
        $to_remove = array("(", ")", "-", " ");
        $telefone = str_replace($to_remove, '', $telefone);

        //tirando parenteses e o traço do whatsapp
        $to_remove = array("(", ")", "-", " ");
        $whatsapp = str_replace($to_remove, '', $whatsapp);

        //Se não o número for vazio, a variavel irá receeber um valor nulo
        if($whatsapp == ""){
            $whatsapp = null;
        }

        //query para atualizar a imagem do bd (CEP)
        $sql = "UPDATE address 
                    SET location_cep = ?,
                    location_address = ?,
                    location_number = ?,
                    location_district = ?,
                    location_state = ?
                    WHERE id = ?";
        $stmt = $mysql->prepare($sql);
        
        //executar o update
        $stmt->execute([$CEPAlterado, $rua, $numero, $bairro, $estado, $address_id]);

        //query para atualizar a imagem do bd (ONG)
        $sqlSnd = "UPDATE ong 
                    SET ong_description = ?,
                    ong_purpose = ?,
                    ong_phone = ?,
                    ong_business_hours = ?,
                    ong_img = ?,
                    ong_whatsapp = ?,
                    ong_facebook_url = ? 
                    WHERE id = ?";
        $stmtSnd = $mysql->prepare($sqlSnd);
        
        //executar o update
        $stmtSnd->execute([$descricao, $proposito, $telefone, $horarioFunc, $newNameImg, $whatsapp, $facebook, $id]);
        
        //verificando se as duas querys deram certo
        if($stmt && $stmtSnd){// Se sim, cairá aqui
            header('Location: ../perfil.php?msg=sucess_perfil');
        }else{ // se não, cairá aqui
           header('Location: ../perfil.php?msg=error_perfil');
        }
    } else { //caso a foto upada seja muito grande, abrirá um modal informando a ONG
            header('Location: ../perfil.php?msg=invalid_size_logo&size=' . $tamanhoImg . '');
    }  
    
} elseif($_FILES['arquivo']['error'] == '4'){
    //tirando o traço do CEP
    $CEPAlterado = str_replace('-', '',$CEP);
    
    //tirando parenteses e o traço do telefone
    $to_remove = array("(", ")", "-", " ");
    $telefone = str_replace($to_remove, '', $telefone);

    //tirando parenteses e o traço do whatsapp
    $to_remove = array("(", ")", "-", " ");
    $whatsapp = str_replace($to_remove, '', $whatsapp);

    //Se não o número for vazio, a variavel irá receeber um valor nulo
    if($whatsapp == ""){
        $whatsapp = null;
    }

   //query para atualizar a imagem do bd (CEP)
    $sql = "UPDATE address 
                SET location_cep = ?,
                location_address = ?,
                location_number = ?,
                location_district = ?,
                location_state = ?
                WHERE id = ?";
    $stmt = $mysql->prepare($sql);
    
    //executar o update
    $stmt->execute([$CEPAlterado, $rua, $numero, $bairro, $estado, $address_id]);

    //query para atualizar a imagem do bd (ONG)
    $sqlSnd = "UPDATE ong 
                SET ong_description = ?,
                ong_purpose = ?,
                ong_phone = ?,
                ong_business_hours = ?,
                ong_whatsapp = ?,
                ong_facebook_url = ?
                WHERE id = ?";
    $stmtSnd = $mysql->prepare($sqlSnd);
    
    //executar o update
    $stmtSnd->execute([$descricao, $proposito, $telefone, $horarioFunc, $whatsapp, $facebook, $id]);
    
    //verificando se as duas querys deram certo
    if($stmt && $stmtSnd){// Se sim, cairá aqui
        header('Location: ../perfil.php?msg=sucess_perfil');
    }else{// Se não, cairá aqui
        header('Location: ../perfil.php?msg=error_perfil');
    }
}


