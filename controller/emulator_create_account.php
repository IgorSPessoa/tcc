<?php
 if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}

include "../connect.php";

$acc_type = $_POST["acc_type"];
$email = $_POST["email"];

//-- Verificando se e-mail está em uso por alguem

// Users
$query_mail_users = $mysql->prepare("SELECT email FROM user WHERE email = '$email';");
$query_mail_users->execute();
$CountUser = $query_mail_users->rowCount();

//Se o contador for maior que um resultado, irá voltar para a página de criação de conta com um erro 
if($CountUser >= 1){
    $msg = "invalid_email";
    header('Location: ../criar_conta.php?msg=invalid_email');
    die();
}

// Ong
$query_mail_ongs = $mysql->prepare("SELECT ong_email FROM ong WHERE ong_email = '$email';");
$query_mail_ongs->execute();
$CountOng = $query_mail_ongs->rowCount();

//Se o contador for maior que um resultado, irá voltar para a página de criação de conta com um erro 
if($CountOng >= 1){
    $msg = "invalid_email";
    header('Location: ../criar_conta_ong.php?msg=invalid_email');
    die();
}

//verificando o tipo de conta a ser criada
if($acc_type == "user"){
    // Criando conta de um usuário
    $nome = $_POST["name"];
    $CEP = $_POST["cep"];
    $telefone = $_POST["phone"];
    $confirSenha = $_POST['ConfirmPwd'];
    $senha = $_POST["senha"];
    $img = "preview.jpg";

    //verificação de senha
    if($senha == $confirSenha){
        //criptografando a senha
        $senha = md5($senha);

        //tirando o traço do CEP
        $CEP = str_replace('-', '', $CEP);

        //tirando parenteses e o traço do telefone
        $to_remove = array("(", ")", "-", " ");
        $telefone = str_replace($to_remove, '', $telefone);
        
        //query de criação de user
        $sql = "INSERT INTO user
                              (name, email, pwd, img, phone, cep, created_at ) 
                        VALUES
                              (?, ?, ?, ?, ?, ?, CURRENT_DATE());";

        //preparando a query                      
        $query = $mysql->prepare($sql);

        //executando a querry com as variaveis necessárias
        $query->execute([$nome, $email, $senha, $img, $telefone, $CEP]);

        //verificando se o resultado da pesquisa deu verdadeiro(true)
        if($query){//caso sim, irá cair aqui
            header('Location: ../login.php?msg=sucess_create');
        }else{//caso não, irá cair aqui
             header('Location: ../criar_conta.php?msg=error_create');
        }
    } else {//caso as senhas não se coincidirem, irá voltar para a página de criação de conta
        header('Location: ../criar_conta.php?msg=invalid_create_pwd');
    } 
} elseif($acc_type == "ong"){ //verificando o tipo de conta a ser criada
    // Criando conta de uma ONG
    $ong_nome = $_POST["ong_name"];
    $ong_descricao = $_POST["ong_description"];
    $ong_img = "default_avatar.jpg";
    $data_abertura = $_POST["opening_date"]; 
    $data_Funcion = $_POST["opening_hours"]; 
    $proposito = $_POST["ong_reason"]; 
    $telefone = $_POST["phone"];  
    $ong_CEP = $_POST["ong_cep"];
    $ong_rua = $_POST["ong_address"];
    $ong_numero = $_POST["ong_number"]; 
    $ong_bairro = $_POST["ong_district"]; 
    $ong_estado = $_POST["ong_state"]; 
    $senha = $_POST["senha"];
    $confirmarSenha = $_POST["ConfirmPwd"];
    $visualizacao = "0"; 


    //Colocando o estado(por escrito) no $estado, pois no VIACEP não está disponibilizado esta função (apenas em o UF)
    if($ong_estado == "AC"){
        $ong_estado = "Acre";
    } elseif($ong_estado == "AL"){
        $ong_estado = "Alagoas";
    } elseif($ong_estado == "AP"){
        $ong_estado = "Amapá";
    } elseif($ong_estado == "AM"){
        $ong_estado = "Amazonas";
    } elseif($ong_estado == "BA"){
        $ong_estado = "Bahia";
    } elseif($ong_estado == "CE"){
        $ong_estado = "Ceará";
    } elseif($ong_estado == "DF"){
        $ong_estado = "Distrito Federal";
    } elseif($ong_estado == "ES"){
        $ong_estado = "Espírito Santo";
    } elseif($ong_estado == "GO"){
        $ong_estado = "Goiás";
    } elseif($ong_estado == "MA"){
        $ong_estado = "Maranhão";
    } elseif($ong_estado == "MT"){
        $ong_estado = "Mato Grosso";
    } elseif($ong_estado == "MS"){
        $ong_estado = "Mato Grosso do Sul";
    } elseif($ong_estado == "MG"){
        $ong_estado = "Minas Gerais";
    } elseif($ong_estado == "PA"){
        $ong_estado = "Pará";
    } elseif($ong_estado == "PB"){
        $ong_estado = "Paraíba";
    } elseif($ong_estado == "PR"){
        $ong_estado = "Paraná";
    } elseif($ong_estado == "PE"){
        $ong_estado = "Pernambuco";
    } elseif($ong_estado == "PI"){
        $ong_estado = "Piauí";
    } elseif($ong_estado == "RJ"){
        $ong_estado = "Rio de Janeiro";
    } elseif($ong_estado == "RN"){
        $ong_estado = "Rio Grande do Norte";
    } elseif($ong_estado == "RS"){
        $ong_estado = "Rio Grande do Sul";
    } elseif($ong_estado == "RO"){
        $ong_estado = "Rondônia";
    } elseif($ong_estado == "RR"){
        $ong_estado = "Roraima";
    } elseif($ong_estado == "SC"){
        $ong_estado = "Santa Catarina";
    } elseif($ong_estado == "SP"){
        $ong_estado = "São Paulo";
    } elseif($ong_estado == "SE"){
        $ong_estado = "Sergipe";
    } elseif($ong_estado == "TO"){
        $ong_estado = "Tocantins";
    }

    //verificação de senha
    if($senha == $confirmarSenha){
        //criptografando a senha
        $senha = md5($senha);

        //tirando o traço do CEP
        $ong_CEP = str_replace('-', '', $ong_CEP);

        //tirando parenteses e o traço do telefone
        $to_remove = array("(", ")", "-", " ");
        $telefone = str_replace($to_remove, '', $telefone);

        //query de criação do endereço da ong
        $sql = " INSERT INTO address
                                 (location_cep,
                                 location_address,
                                 location_number,
                                 location_district,
                                 location_state)
                            VALUES 
                                (?, ?, ?, ?, ?);";

        //preparando a query                      
        $query = $mysql->prepare($sql);

        //executando a querry com as variaveis necessárias
        $query->execute([$ong_CEP, $ong_rua, $ong_numero, $ong_bairro, $ong_estado]);

        //pengando o id do cadastro de cep e salvando em uma variavel 
        $LAST_ID = $mysql->lastInsertId();

        //query de criação de ong
        $sqlSnd = "INSERT INTO ong
                              (address_id,
                              ong_name, 
                              ong_description, 
                              ong_email, 
                              ong_password, 
                              ong_purpose, 
                              ong_phone, 
                              ong_opening_date, 
                              ong_business_hours,
                              ong_img, 
                              ong_view) 
                        VALUES
                              (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        
        //preparando a query                      
        $querySnd = $mysql->prepare($sqlSnd);

        //executando a querry com as variaveis necessárias
        $querySnd->execute([$LAST_ID, $ong_nome, $ong_descricao, $email, $senha, $proposito, $telefone, $data_abertura, $data_Funcion, $ong_img, $visualizacao]);
    
        //verificando se as duas querys voltarem com resultado válido (true)
        if($query && $querySnd){//caso sim, irá cair aqui
            header('Location: ../login.php?msg=sucess_create');
        }else{//caso não, irá cair aqui
            header('Location: ../criar_conta_ong.php?msg=error_create');
        }
    } else {//caso as senhas não se coincidirem, irá voltar para a página de criação de conta
        header('Location: ../criar_conta_ong.php?msg=invalid_create_pwd');
    }
}

?>