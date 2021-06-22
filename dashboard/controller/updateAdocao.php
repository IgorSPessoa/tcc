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

//Conectando com o servidor mysql
include '../../connect.php';

//Declarando os nomes das variáveis pegas no NovaAdocao
$nome = "$_POST[animal_name]";
$descricao = "$_POST[animal_description]";
$raca = "$_POST[animal_race]";
$peso = "$_POST[animal_weight]";
$categoria = "$_POST[animal_category]";
$sexo = "$_POST[animal_gender]";
$animal = "$_POST[animal_type]";
$idade = "$_POST[animal_age]";
$data_chegada = "$_POST[animal_ong_since]";
$situacao = "$_POST[animal_status]";
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
        if($nome == "" || $descricao == "" || $animal == "" || $raca = "" || $peso = ""){//Se estiver ele retorna um aviso
            header('Location: ../editarAdoacao.php?id=' . $id . '&msg=invalid_field');
        } else { //Se não, continua a operaçãp
                //pegando o nome da imgagem no Banco de dados
            $img = $mysql->prepare("SELECT animal_age FROM animal_adoption WHERE id = $id");
            $img->execute();

            //verificando se existe uma imagem no bd
            if($linha = $img->fetch(PDO::FETCH_ASSOC)){
                $name = $linha['img']; //Se existir vai entrar na variavel $name
            }

            if(file_exists("../../imgsUpdate/$name")) { //verificando se ela existe no diretorio
                unlink("../../imgsUpdate/$name"); //Tirando a imgagem do diretorio
            } 

            //diretorio
            $uploaddir = "../../imgsUpdate/";

            //pegando o nome da ong
            $email = $_SESSION['email'];
            $nameOng = strstr($email, '@', TRUE);

            //definindo onovo nome da imagem como tempo e nome da ong    
            $newNameImg = time() . md5($nameOng) . $ext;

            //Mudando a localização do arquivo
            move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploaddir . $newNameImg);

            //query de atualização da adoção
            $sql = "UPDATE animal_adoption 
                    SET animal_name = ?, 
                        animal_description = ?, 
                        animal_type = ?, 
                        animal_age = ?, 
                        animal_gender = ?, 
                        animal_ong_since = ?,
                        animal_photo = ?, 
                        animal_race = ?, 
                        animal_weight = ?, 
                        animal_category = ?,
                        adoption_situation = ?
                    WHERE id = ?";
            //preparando a query
            $stmt = $mysql->prepare($sql);

            //executando a query
            $stmt->execute([$nome, $descricao, $animal, $idade, $sexo, $data_chegada, $newNameImg, $raca, $peso, $categoria, $situacao, $id]);
            
            //verificando se o resultado da query foi verdadeiro
            if($stmt){//se sim, cairá aqui
                header('Location: ../adocoes.php?msg=sucess_updateAdoption');
            }else{//se não, cairá aqui
                header('Location: ../editarAdoacao.php?id=' . $id . '&msg=error_updateAdoption');
            }
        }
    } else {//caso o tamanho da imagem for muito grande, cairá aqui
        header('Location: ../editarAdoacao.php?id=' . $id . '&msg=invalid_size_animal');
    }   
} elseif($_FILES['arquivo']['error'] == '4'){//caso o a ONG não deseje atualizar a foto, cairá aqui
    //Verificando se algum campo está vazio
    if($nome == "" || $descricao == "" || $animal == "" || $raca == "" || $peso == ""){//Se estiver ele retorna um aviso
        header('Location: ../editarAdoacao.php?id=' . $id . '&msg=invalid_field');
     } else {//Se não, continua a operação
        //query de atualização da Adoção
        $sql = "UPDATE animal_adoption 
                    SET animal_name = ?, 
                        animal_description = ?, 
                        animal_type = ?, 
                        animal_age = ?, 
                        animal_gender = ?, 
                        animal_ong_since = ?, 
                        animal_race = ?, 
                        animal_weight = ?, 
                        animal_category = ?,
                        adoption_situation = ?
                    WHERE id = ?";
        //preparando a query
        $stmt = $mysql->prepare($sql);

        //executando a query
        $stmt->execute([$nome, $descricao, $animal, $idade, $sexo, $data_chegada, $raca, $peso, $categoria, $situacao, $id]);
        
        //verificando se o resultado da query foi verdadeiro 
        if($stmt){//se sim, cairá aqui
            header('Location: ../adocoes.php?msg=sucess_updateAdoption');
        }else{//se não cairá aqui
            header('Location: ../editarAdoacao.php?id=' . $id . '&msg=error_updateAdoption');
        }
     }
}


