<?php

include "../connect.php";

$nome = $_POST["nome"];
$telefone = $_POST["telefone"];

$situacao_animal = $_POST["situacao_animal"];
$animal_descricao = $_POST["animal_descrição"];
$animal_tipo = $_POST["animal_tipo"];

//verificando se o arquivo está vazio
if (isset($_FILES['foto_animal'])){
    
    //pegando a extensão da imagem
    $separa = explode(".", $_FILES['foto_animal']['name']);
    $separa = array_reverse($separa);
    $tipoimg = $separa[0];
    $ext = strtolower("." . $tipoimg);


    if($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png' || $ext == '.svg'){ //Verificando se o arquivo é uma img
        // Definindo o limite do tamanho do arquivo
        $limite = 10240000; 
        
        //Definindo o tamanho em uma variavel
        $tamanhoImg = $_FILES['foto_animal']['size']; 
        
        if($tamanhoImg <= $limite){
            //definindo o nome da img como tempo e nome da ong    
            $foto_animal = time() . md5($telefone) . $ext;

            //define onde a imgagem vai ser levada
            $diretorio = '../imgs/';

            //pegando nome temporario
            $tpmName = $_FILES['foto_animal']['tmp_name'];

            //Mudar a localização do arquivo
            move_uploaded_file($tpmName, $diretorio . $foto_animal);
        }else{//Se o arquivo for maior que 10mb
            echo "<script language='javascript' type='text/javascript'>alert('Arquivo muito grande, o tamanho máximo do arquivo é 10MB. Tamanho do arquivo atual: $tamanhoImg'); window.location = ' ../report.php';</script>";
        }
    }else{//se o arquivo não tiver a extensão desejada
        echo "<script language='javascript' type='text/javascript'>alert('O arquivo não é uma imagem, por favor faça o upload de uma imagem .png, .jpg ou .svg . Extensão atual: $ext'); window.location = ' ../report.php';</script>";
    }
}

$endereco = $_POST["endereco"];
$observacao = $_POST["observacao"];

//verificando se o arquivo está vazio
if (isset($_FILES['foto_address'])){
    
    //pegando a extensão da imagem
    $separa = explode(".", $_FILES['foto_address']['name']);
    $separa = array_reverse($separa);
    $tipoimg = $separa[0];
    $ext = strtolower("." . $tipoimg);


    if($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png' || $ext == '.svg'){ //Verificando se o arquivo é uma img
        // Definindo o limite do tamanho do arquivo
        $limite = 10240000; 
        
        //Definindo o tamanho em uma variavel
        $tamanhoImg = $_FILES['foto_address']['size']; 
        
        if($tamanhoImg <= $limite){
            //definindo o nome da img como tempo e nome da ong    
            $foto_address = time() . md5($telefone) . $ext;

            //define onde a imgagem vai ser levada
            $diretorio = '../imgs/';

            //pegando nome temporario
            $tpmName = $_FILES['foto_address']['tmp_name'];

            //Mudar a localização do arquivo
            move_uploaded_file($tpmName, $diretorio . $foto_address);
        }else{//Se o arquivo for maior que 10mb
            echo "<script language='javascript' type='text/javascript'>alert('Arquivo muito grande, o tamanho máximo do arquivo é 10MB. Tamanho do arquivo atual: $tamanhoImg'); window.location = ' ../report.php';</script>";
        }
    }else{//se o arquivo não tiver a extensão desejada
        echo "<script language='javascript' type='text/javascript'>alert('O arquivo não é uma imagem, por favor faça o upload de uma imagem .png, .jpg ou .svg . Extensão atual: $ext'); window.location = ' ../report.php';</script>";
    }
}

//linha de comando que irá ser chamada no bd
$sql =" INSERT INTO animal_report 
            (author_name, author_phone, animal_situation, animal_description, animal_type, animal_photo, localization_lastview, localization_observation, localization_photo) 
        VALUES 
            (?,?,?,?,?,?,?,?,?)";
//preparando para executar
$stmt = $mysql->prepare($sql);

// executando a query
$stmt->execute([$nome, $telefone, $situacao_animal, $animal_descricao, $animal_tipo, $foto_animal, $endereco, $observacao, $foto_address]);

if($stmt){
    echo "<script language='javascript' type='text/javascript'>alert('Report enviado!'); window.location = ' ../reportar.php';</script>";
}else{
    echo "<script language='javascript' type='text/javascript'>alert('Falha ao enviar o report!'); window.location = ' ../reportar.php';</script>";
}

?>