<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$id_user = $_SESSION['id'];
//conexão com banco de dados
include "../connect.php";


$CEP = $_POST["cep"];
$telefone = $_POST["phone"];
$confirSenha = $_POST['ConfirmPwd'];
$senha = $_POST["senha"];

if ($senha == $confirSenha) {
    //criptografando a senha
    $senha = md5($senha);

    //tirando o traço do CEP
    $CEP = str_replace('-', '', $CEP);

    //tirando parenteses e o traço do telefone
    $telefone = str_replace('(', '', $telefone);
    $telefone = str_replace(')', '', $telefone);
    $telefone = str_replace('-', '', $telefone);
    $telefone = str_replace(' ', '', $telefone);
    //query de criação de user
    $sql = "UPDATE user SET pwd = ?, cep = ?, phone = ? WHERE id ='$id_user'";
    //preparando a query                      
    $query = $mysql->prepare($sql);

    //executando a querry com as variaveis necessárias
    $query->execute([$senha, $CEP, $telefone]);


    if ($query) {
        header('Location: ../user_dashboard.php?msg=sucess_perfil');
    } else {
        header('Location: ../user_dashboard.php?msg=error_perfil');
    }
} else {
    header('Location: ../user_dashboard.php?msg=invalid_create_pwd');
}
