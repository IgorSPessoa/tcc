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
    
    // Definindo o limite do tamanho do arquivo
    $limite = 10240000; 
    
    //Definindo o tamanho em uma variavel
    $tamanhoImg = $_FILES['arquivo']['size']; 
    
    if($tamanhoImg <= $limite){
        //Verificando se algum campo está vazio
        if($nome == "" || $descricao == "" || $idade == "" || $animal == ""){//Se estiver ele retorna um aviso
            header('Location: ../editarAdoacao.php?id=' . $id . '&msg=invalid_field');
        } else { //Se não, continua a operaçãp
                //pegando o nome da imgagem no Banco de dados
            $img = $mysql->prepare("SELECT animal_age FROM animal_adoption WHERE id = $id");
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

            $sql = "UPDATE animal_adoption SET animal_name = ?, animal_description = ?, animal_photo = ?, animal_age = ?, animal_type = ? WHERE id = ?";
            $stmt = $mysql->prepare($sql);

            $stmt->execute([$nome, $descricao, $newNameImg, $idade, $animal, $id]);
            
            if($stmt){
                header('Location: ../adocoes.php?msg=sucess_updateAdoption');
            }else{
                header('Location: ../editarAdoacao.php?id=' . $id . '&msg=error_updateAdoption');
            }
        }
    } else {
        header('Location: ../editarAdoacao.php?id=' . $id . '&msg=invalid_size_animal');
    }   
} elseif($_FILES['arquivo']['error'] == '4'){
    //Verificando se algum campo está vazio
    if($nome == "" || $descricao == "" || $idade == "" || $animal == ""){//Se estiver ele retorna um aviso
        header('Location: ../editarAdoacao.php?id=' . $id . '&msg=invalid_field');
     } else {//Se não, continua a operação
        $sql = "UPDATE animal_adoption SET animal_name = ?, animal_description = ?, animal_age = ?, animal_type = ? WHERE id = ?";
        $stmt = $mysql->prepare($sql);

        $stmt->execute([$nome, $descricao, $idade, $animal, $id]);
        
        if($stmt){
            header('Location: ../adocoes.php?msg=sucess_updateAdoption');
        }else{
            header('Location: ../editarAdoacao.php?id=' . $id . '&msg=error_updateAdoption');
        }
     }
}


