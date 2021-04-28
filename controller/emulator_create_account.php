<?php
include "../connect.php";

$acc_type = $_POST["acc_type"];
$email = $_POST["email"];
$senha = md5($_POST["senha"]);

//-- Verificando se e-mail está em uso por alguem
// Users
$query_mail_users = $mysql->query("SELECT email FROM user WHERE email = '$email';");
if(mysqli_num_rows($query_mail_users)){
    die("O e-mail já está em uso!<br><a href='javascript:history.go(-1)'>Clique aqui e tente com outro e-mail</a>");
}
// Ong
$query_mail_ongs = $mysql->query("SELECT email FROM ong_acess WHERE email = '$email';");
if(mysqli_num_rows($query_mail_ongs)){
    die("O e-mail já está em uso!<br><a href='javascript:history.go(-1)'>Clique aqui e tente com outro e-mail</a>");
}

if($acc_type == "user"){
  // Criando conta de um usuário
    $nome = $_POST["nome"];

    $query = $mysql->query("INSERT INTO user(name, email, pwd) VALUES('$nome', '$email', '$senha');");
    
}
if($acc_type == "ong"){
    // Criando conta de uma ONG
    $ong_name = $_POST["ong_name"];
    $ong_description = $_POST["ong_description"];
    $ong_address = $_POST["ong_address"];
    $ong_cep = $_POST["ong_cep"];

    $queryOngData = $mysql->query("INSERT INTO ong(name, description, img, address, address_cep) VALUES('$ong_name', '$ong_description', 'ong01.jpg', '$ong_address', '$ong_cep');");
    
    /* ! Atenção !
    Deveriamos usar algo como $queryOngData->insert_id; para obter o ID.
    Não consegui fazer isso agora, então fiz uma gambiarra para funcionar, pegando o id DA ONG adicionado com base no NOME adicionado. 

    NÃO use isto em produção.
    */
    $result = $mysql->query("SELECT id FROM ong WHERE name = '$ong_name';");
    while($row = $result->fetch_row()){
        $ong_id = $row[0];
    }

    if($queryOngData){
        $query = $mysql->query("INSERT INTO ong_acess(ong_id, email, senha) VALUES($ong_id, '$email', '$senha');");
    }else{
        die("Erro interno!");
    }
    
}



if($query){
    echo "Conta criada, tipo: $acc_type!<br><a href='../login.php'>Fazer login</a>";
}else{
    echo "Falha ao criar a conta!";
}

?>