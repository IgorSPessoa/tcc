<?php
include "../../connect.php";

session_start();

$name = $_POST["name"];
$description = $_POST["description"];
$ong_id = $_SESSION['id'];

$query = $mysql->query("INSERT INTO animal_adoption(ong_id, name, description, img) VALUES($ong_id, '$name', '$description', 'dog3.png');");
if($query){
    echo "Animal adicionado com sucesso! <br><a href='../adocao.php'>Voltar</a>";
}else{
    die("Erro interno");
}
?>