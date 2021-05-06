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

//Se houver um novo avatar enviado, delete o antigo e atualize um novo
if($_FILES['file']['name'] != ""){
    //pegando a extensão da imagem
    $separa = explode(".", $_FILES['file']['name']);
    $separa = array_reverse($separa);
    $tipoimg = $separa[0];
    $ext = strtolower("." . $tipoimg);
    
    if($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png' || $ext == '.svg'){
        // Definindo o limite do tamanho do arquivo
        $limite = 10240000; 
        
        //Definindo o tamanho em uma variavel
        $tamanhoImg = $_FILES['file']['size']; 
        
        if($tamanhoImg <= $limite){
            //pegando o nome da imgagem no Banco de dados
            $img = $mysql->prepare("SELECT img FROM ong WHERE id = $id");
            $img->execute();

            //verificando se existe uma imagem no bd
            if($linha = $img->fetch(PDO::FETCH_ASSOC)){
                $name = $linha['img']; //Se existir vai entrar na variavel $name
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
            move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $newNameImg);

            //query para atualizar a imagem do bd
            $sql = "UPDATE ong SET img = ? WHERE id = ?";
            $stmt = $mysql->prepare($sql);
            
            //executar o update
            $stmt->execute([$newNameImg, $id]);
            
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
} elseif($_FILES['file']['error'] == '4'){
    echo "<script language='javascript' type='text/javascript'>alert('Nenhuma imagem foi upada, tente novamente!'); window.location = ' ../perfil.php';</script>";
}
