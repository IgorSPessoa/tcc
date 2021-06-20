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
$to_remove = array("(", ")", "-", " ");
$telefone = str_replace($to_remove, '', $telefone);

if($senha === $confirSenha){

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

            //verificando se a imgagem for diferente de preview.jgp (pois é uma imagem padrão do sistema)
            if($name != 'preview.jpg'){
                if(file_exists("../imgsUpdate/$name")) { //verificando se ela existe no diretorio
                    unlink("../imgsUpdate/$name"); //Tirando a imgagem do diretorio
                } 
            }

            //query para pegar o pwd caso o usuário não queria alterar a senha dele
            $query = $mysql->prepare("SELECT pwd FROM user WHERE id = $id_user;");
            $query->execute();
            
            //puxando o resultado para uma variavel
            if($linha = $query->fetch(PDO::FETCH_ASSOC)){   
                $senhaBD = $linha['pwd'];
            }

            //verificando se a senha é diferente de vazio
            if($senha !== ""){ //se sim, criptografa
                //criptografando a senha
                $senhaAlterada = md5($senha);
            } else{ //Se a senha mudada for vazia, irá colocar senha já colocada pelo usuário já criptografada
                $senhaAlterada = $senhaBD;
            }

            //diretorio
            $uploaddir = "../imgsUpdate/";

            //pegando o nome da ong
            $email = $_SESSION['email'];
            $nameUser = strstr($email, '@', TRUE);

            //definindo onovo nome da imagem como tempo e nome da ong    
            $nameImg = time() . md5($nameUser) . $ext;

            //movendo para o arquivo para a pasta solititada 
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploaddir . $nameImg);

            //query de atualização dos dados do usuario
            $sql = "UPDATE user SET pwd = ?, img = ?,phone = ?,cep = ? WHERE id = ?";
            $stmt = $mysql->prepare($sql);
            
            //executa a query
            $stmt->execute([$senhaAlterada, $nameImg, $telefone, $CEP, $id_user]);
            
            //Validando o resultado
            if($stmt){ //caso de certo
                header('Location: ../user_dashboard.php?msg=sucess_perfil');
            }else{ //caso de errado
                header('Location: ../user_dashboard.php?msg=error_perfil');
            }
        } else{ //se o tamanho da imagem for muito grande irá mostrar um modal para o usuario
            header('Location: ../user_dashboard.php?msg=invalid_size_user&size=' . $tamanhoImg . '');
        }  
    } elseif($_FILES['arquivo']['error'] == '4'){ //caso o usuário queira atualizar os dados sem a foto, irá cair neste if 

        //query para pegar o pwd caso o usuário não queria alterar a senha dele
        $query = $mysql->prepare("SELECT pwd FROM user WHERE id = $id_user;");
        $query->execute();
        
        //puxando o resultado para uma variavel
        if($linha = $query->fetch(PDO::FETCH_ASSOC)){   
            $senhaBD = $linha['pwd'];
        }

        //verificando se a senha é diferente de vazio
        if($senha !== ""){ //se sim, criptografa
            //criptografando a senha
            $senhaAlterada = md5($senha);
        } else{ //Se a senha mudada for vazia, irá colocar senha já colocada pelo usuário já criptografada
            $senhaAlterada = $senhaBD;
        }

        //query de atualização dos dados do usuario
        $sql = "UPDATE user SET pwd = ?, phone = ?,cep = ? WHERE id = ?";
        $stmt = $mysql->prepare($sql);

        //executa a query
        $stmt->execute([$senhaAlterada, $telefone, $CEP, $id_user]);
        
        //Validando o resultado
        if($stmt){//caso de certo
            header('Location: ../user_dashboard.php?msg=sucess_perfil');
        }else{//caso de errado
            header('Location: ../user_dashboard.php?msg=error_perfil');
        }
    }
} else{ //Se a senhas não se concidierem irá aparecer um modal aparecendo o erro
    header('Location: ../user_dashboard.php?msg=invalid_create_pwd');
}
