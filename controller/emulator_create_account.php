<?php
 if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}

include "../connect.php";

$acc_type = $_POST["acc_type"];
$email = $_POST["email"];
$senha = md5($_POST["senha"]);

//-- Verificando se e-mail está em uso por alguem
// Users
$query_mail_users = $mysql->prepare("SELECT email FROM user WHERE email = '$email';");
$query_mail_users->execute();
$CountUser = $query_mail_users->rowCount();

if($CountUser >= 1){
    echo "<script language='javascript' type='text/javascript'>alert('O e-mail já está em uso! Tente novamente com outro e-mail'); window.location = ' ../criar_conta.php';</script>";
    die();
}
// Ong
$query_mail_ongs = $mysql->prepare("SELECT email FROM ong_acess WHERE email = '$email';");
$query_mail_ongs->execute();
$CountOng = $query_mail_ongs->rowCount();

if($CountOng >= 1){
    echo "<script language='javascript' type='text/javascript'>alert('O e-mail já está em uso! Tente novamente com outro e-mail'); window.location = ' ../criar_conta_ong.php';</script>"; 
    die();
}

if($acc_type == "user"){
  // Criando conta de um usuário
    $nome = $_POST["nome"];

    $query = $mysql->prepare("INSERT INTO user(name, email, pwd) VALUES('$nome', '$email', '$senha');");
    $query->execute();
    
}
if($acc_type == "ong"){
    // Criando conta de uma ONG
    $ong_name = $_POST["ong_name"];
    $ong_description = $_POST["ong_description"];
    $ong_address = $_POST["ong_address"];
    $ong_cep = $_POST["ong_cep"];

    $queryOngData = $mysql->prepare("INSERT INTO ong(name, description, img, address, address_cep) VALUES('$ong_name', '$ong_description', 'ong01.jpg', '$ong_address', '$ong_cep');");
    $queryOngData->execute();

    /* ! Atenção !
    Deveriamos usar algo como $queryOngData->insert_id; para obter o ID.
    Não consegui fazer isso agora, então fiz uma gambiarra para funcionar, pegando o id DA ONG adicionado com base no NOME adicionado. 

    NÃO use isto em produção.
    */
    $result = $mysql->prepare("SELECT id FROM ong WHERE name = '$ong_name';");
    $result->execute();

    while($row = $result->fetch(PDO::FETCH_BOTH)){
        $ong_id = $row[0];
    }

    if($queryOngData){
        $query = $mysql->query("INSERT INTO ong_acess(ong_id, email, senha) VALUES($ong_id, '$email', '$senha');");
    }else{
        die("Erro interno!");
    }
    
}



if($query){
    //echo "<script language='javascript' type='text/javascript'>window.location = '../login.php?mensagem=successCreate&type=$acc_type';</script>";
    echo "<script language='javascript' type='text/javascript'>alert('Conta criada com sucesso!, tipo de conta: $acc_type'); window.location = ' ../login.php';</script>";
}else{
    echo "<script language='javascript' type='text/javascript'>alert('Falha ao criar a conta!'); window.location = ' ../login.php';</script>";
}

?>