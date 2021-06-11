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
//Conectando com o banco
include '../../connect.php';

//pegando o id da ong logada
$idReport = $_GET['id'];
$data_aceite = '0000-00-00';
$situacao = 'pending';
$comments = "";
$imgReport = 'preview.jpg';

$sql = "UPDATE animal_report SET ong_id = ?, report_date_accepted = ?, report_situation = ?, report_comments = ?, report_img = ? WHERE id = ?";
$stmt = $mysql->prepare($sql);
 
$stmt->execute([$idOng, $data_aceite, $situacao, $comments, $imgReport, $idReport]);

if($stmt){
    header('Location: ../visualizaReport.php?id=' . $idReport . '&msg=sucess_unlinkReport');
} else {
    header('Location: ../visualizaReport.php?id=' . $idReport . '&msg=error_unlinkReport');
}

?>