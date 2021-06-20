<?php 
//Iniciando sessão
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (isset($_SESSION['email']) == true) {
    // Fazendo conexão com o banco de dados
    include '../connect.php';

    //pegando a variavel
    $idOng = "$_GET[id]";
    $idOng = substr($str, 3);
    
    //query para ser levada para o banco de dados
    $newSql = "UPDATE ong 
                      SET ong_view = ong_view + 1 
                      WHERE id = ?;";

    //preparando e executando a querry
    $stmt = $mysql->prepare($newSql);
    $stmt->execute([$idOng]);  

    //verificando se o resultado deu certo 
    if($stmt){
        //voltando para a página da ong selecionada
        echo "<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>";
        echo "<script type='text/javascript'> 
                function backHome(){
                    return $.ajax({
                        type: 'GET',
                        url:'../ong_profile.php',
                        data: $idOng
                    });
                }
              </script>";
    }
}
?>