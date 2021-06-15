<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$id_user = $_SESSION['id'];
//conexão com banco de dados
include "../connect.php";

$CEP = $_POST["cep"];
$telefone = $_POST["phone"];
$senha = $_POST["senha"];
$confirSenha = $_POST['ConfirmPwd'];

//tirando o traço do CEP
$CEP = str_replace('-', '', $CEP);

//tirando parenteses e o traço do telefone
$telefone = str_replace('(', '', $telefone);
$telefone = str_replace(')', '', $telefone);
$telefone = str_replace('-', '', $telefone);
$telefone = str_replace(' ', '', $telefone);

if($senha === $confirSenha){

    //criptografando a senha
    $senha = md5($senha);

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
            $img = $mysql->prepare("SELECT img FROM user WHERE id = $id_user");
            $img->execute();

            //verificando se existe uma imagem no bd
            if($linha = $img->fetch(PDO::FETCH_ASSOC)){
                $name = $linha['img']; //Se existir vai entrar na variavel $name
            }
            if($name != 'preview.jpg'){
                if(file_exists("../imgsUpdate/$name")) { //verificando se ela existe no diretorio
                    unlink("../imgsUpdate/$name"); //Tirando a imgagem do diretorio
                } 
            }
            
            //diretorio
            $uploaddir = "../imgsUpdate/";

            //pegando o nome da ong
            $email = $_SESSION['email'];
            $nameUser = strstr($email, '@', TRUE);

            //definindo onovo nome da imagem como tempo e nome da ong    
            $nameImg = time() . md5($nameUser) . $ext;

            move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploaddir . $nameImg);

            $sql = "UPDATE user SET pwd = ?, img = ?,phone = ?,cep = ? WHERE id = ?";
            $stmt = $mysql->prepare($sql);

            $stmt->execute([$senha, $nameImg, $telefone, $CEP, $id_user]);
            
            if($stmt){
                header('Location: ../user_dashboard.php?msg=sucess_perfil');
            }else{
                header('Location: ../user_dashboard.php?msg=error_perfil');
            }
        } else{
            header('Location: ../user_dashboard.php?msg=invalid_size_user&size=' . $tamanhoImg . '');
        }  
    } elseif($_FILES['arquivo']['error'] == '4'){
        $sql = "UPDATE user SET pwd = ?, phone = ?,cep = ? WHERE id = ?";
        $stmt = $mysql->prepare($sql);

        $stmt->execute([$senha, $telefone, $CEP, $id_user]);
        
        if($stmt){
            header('Location: ../user_dashboard.php?msg=sucess_perfil');
        }else{
            header('Location: ../user_dashboard.php?msg=error_perfil');
        }
    }
} else{
    header('Location: ../user_dashboard.php?msg=invalid_create_pwd');
}
