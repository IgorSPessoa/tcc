<?php
//Começando a Sessão
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
//conectando ao banco de dados
include "../connect.php";


$email = $_POST["email"];
$senha = md5($_POST["senha"]);

function CheckRow($query){
    if($query->rowCount() == 1){
        return True;
    }else{
        return False;
    }
}

$err = "";
// Verificando se há conta de usuário
$checkUserAccount = $mysql->prepare("SELECT pwd, id, name, email FROM user WHERE email = '$email';");
$checkUserAccount->execute();

if(CheckRow($checkUserAccount)){
    // Se existir o email na tabela de usuários, compare a senha e faça login.
    while($row = $checkUserAccount->fetch(PDO::FETCH_ASSOC)) {
        // Compara Login
        if($row['pwd'] == $senha){
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['acc_type'] = "user";

            header('Location: ../user_dashboard.php');
            die("user login");
        }else{
            $err = "invalid_login";
        }
    }
}else{
    // Se não, irá tentar no sistema de ONGs.
    $checkOngAccount = $mysql->prepare("SELECT ong_acess.senha, ong.id, ong_acess.email, ong.name FROM ong_acess INNER JOIN ong ON (ong_acess.ong_id = ong.id) WHERE email = '$email';");
    $checkOngAccount->execute();
    if(CheckRow($checkOngAccount)){
        // Se existir o email na tabela de ong, compare a senha e faça login.
        while($row = $checkOngAccount->fetch(PDO::FETCH_ASSOC)) {
            if($row['senha'] == $senha){
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['acc_type'] = "ong";
                
                header('Location: ../dashboard/index.php');
                die("ONG LOGIN");
            }else{
                $err = "invalid_login";
            }
        }
    }else{
        // Conta não localizada.
        $err = "invalid_login";
    }
}

if(!empty($err)){
    header("Location: ../login.php?msg=$err");
}else{
    die("Internal error");
}
?>