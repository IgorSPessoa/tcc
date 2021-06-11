<?php
//Começando a Sessão
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
//conectando ao banco de dados
include "../connect.php";


$email = $_POST["email"];
$senha = md5($_POST["senha"]);

// Esta função verifica se há pelo menos um resultado na query
function CheckRow($query){
    if($query->rowCount() == 1){
        return True;
    }else{
        return False;
    }
}

$err = "";
// Verificando se há conta de usuário
$checkUserAccount = $mysql->prepare("SELECT id, name, pwd, email FROM user WHERE email = ?");
$checkUserAccount->execute([$email]);

if(CheckRow($checkUserAccount)){ // CheckRow verifica se existe pelo menos uma linha no resultado
    // Se existir o email na tabela de usuários, compare a senha e faça login.
    while($row = $checkUserAccount->fetch(PDO::FETCH_ASSOC)) {
        // Verifica se a senha está correta
        if($row['pwd'] == $senha){
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['acc_type'] = "user";

            //redirecionando para o dashboard do usúario 
            header('Location: ../user_dashboard.php?msg=sucess_login');
            die("user login");
        }else{ //caso a senha esteja errada, mandará uma variavel via GET
            $err = "invalid_login_pwd";
        }
    }
}else{
    // Caso não haja e-mail cadastrado na tabela usuários, vamos tentar na tabela de ONG
    $checkOngAccount = $mysql->prepare("SELECT id, address_id, ong_name, ong_email, ong_email, ong_password FROM ong WHERE ong_email = ?;");
    $checkOngAccount->execute([$email]);
    if(CheckRow($checkOngAccount)){
        // Se existir o email na tabela de ong, compare a senha e faça login.
        while($row = $checkOngAccount->fetch(PDO::FETCH_ASSOC)) {
            if($row['ong_password'] == $senha){
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['ong_name'];
                $_SESSION['email'] = $row['ong_email'];
                $_SESSION['address_id'] = $row['address_id'];
                $_SESSION['acc_type'] = "ong";

                //redirecionando para o dashboard da ONG 
                header('Location: ../dashboard/index.php?msg=sucess_login');
                die("ONG LOGIN");
            }else{//caso a senha esteja errada, mandará uma variavel via GET
                $err = "invalid_login_pwd";
            }
        }
    }else{
        // Conta não localizada.
        $err = "invalid_login";
    }
}

if(!empty($err)){//Se estiver com erro, enviará para o login com a varivavel setada
    header("Location: ../login.php?msg=$err");
}else{
    die("Internal error");
}
?>