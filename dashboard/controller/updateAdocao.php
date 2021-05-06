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

//Declarando os nomes das variáveis pegas no NovaAdocao
$nome = "$_POST[name]";
$descricao = "$_POST[description]";
$animal = "$_POST[animal]";
$idade = "$_POST[age]";
$id = "$_POST[id]";

//Se houver um novo avatar enviado, delete o antigo e atualize um novo
if($_FILES['arquivo']['name'] != ""){
    //pegando a extensão da imagem
    $separa = explode(".", $_FILES['arquivo']['name']);
    $separa = array_reverse($separa);
    $tipoimg = $separa[0];
    $ext = strtolower("." . $tipoimg);
    
    if($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png' || $ext == '.svg'){
        // Definindo o limite do tamanho do arquivo
        $limite = 10240000; 
        
        //Definindo o tamanho em uma variavel
        $tamanhoImg = $_FILES['arquivo']['size']; 
        
        if($tamanhoImg <= $limite){
            //pegando o nome da imgagem no Banco de dados
            $img = $mysql->prepare("SELECT img FROM animal_adoption WHERE id = $id");
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
            $newNameImg = time() . md5($nameOng) . $ext;

            move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploaddir . $newNameImg);

            $sql = "UPDATE animal_adoption SET name = ?, description = ?, img = ?, age = ?, type = ? WHERE id = ?";
            $stmt = $mysql->prepare($sql);

            $stmt->execute([$nome, $descricao, $newNameImg, $idade, $animal, $id]);
            
            if($stmt){
                echo "<script language='javascript' type='text/javascript'>alert('Atualização feita com sucesso!'); window.location = ' ../adocoes.php';</script>";
            }else{
                echo "<script language='javascript' type='text/javascript'>alert('Não foi possivel fazer a atualização da adoção!'); window.location = ' ../editarDoacao.php?id=$id';</script>";
            }
        } else {
            echo "<script language='javascript' type='text/javascript'>alert('Arquivo muito grande, o tamanho máximo do arquivo é 10MB. Tamanho do arquivo atual: $tamanhoImg'); window.location = ' ../editarDoacao.php?id=$id';</script>";
        }  
    } else {
        echo "<script language='javascript' type='text/javascript'>alert('O arquivo não é uma imagem, por favor faça o upload de uma imagem .png, .jpg ou .svg . Extensão atual: $ext'); window.location = ' ../editarDoacao.php?id=$id';</script>";
    }
} elseif($_FILES['arquivo']['error'] == '4'){
    $sql = "UPDATE animal_adoption SET name = ?, description = ?, age = ?, type = ? WHERE id = ?";
    $stmt = $mysql->prepare($sql);

    $stmt->execute([$nome, $descricao, $idade, $animal, $id]);
    
    if($stmt){
        echo "<script language='javascript' type='text/javascript'>alert('Atualização feita com sucesso!'); window.location = ' ../adocoes.php';</script>";
    }else{
        echo "<script language='javascript' type='text/javascript'>alert('Não foi possivel fazer a atualização da adoção!'); window.location = ' ../editarDoacao.php';</script>";
    }

}


