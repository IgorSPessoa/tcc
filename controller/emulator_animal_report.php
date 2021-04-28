<?php
include "../connect.php";

$nome = $_POST["nome"];
$telefone = $_POST["telefone"];

$situacao_animal = $_POST["situacao_animal"];
$animal_descricao = $_POST["animal_descrição"];
$foto_animal = "photo.png";

$endereco = $_POST["endereco"];
$observacao = $_POST["observacao"];
$foto_animal = "photo.png";

$query = $mysql->query(" INSERT INTO animal_report (author_name, author_phone, animal_situation, animal_description, animal_photo, localization_lastview, localization_observation, localization_photo) 
                VALUES ('$nome', '$telefone', '$situacao_animal', '$animal_descricao', '$foto_animal', '$endereco', '$observacao', '$foto_animal');");


if($query){
    echo "Report enviado!";
}else{
    echo "Falha ao enviar o report!";
}

?>