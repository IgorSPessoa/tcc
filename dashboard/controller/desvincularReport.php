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
$idOng = 0;
$data_aceite = '0000-00-00';
$situacao = 'pending';
$comments = "";
$imgReport = 'preview.jpg';

$sql = "UPDATE animal_report SET ong_id = ?, report_date_accepted = ?, report_situation = ?, report_comments = ?, report_img = ? WHERE id = ?";
$stmt = $mysql->prepare($sql);
 
$stmt->execute([$idOng, $data_aceite, $situacao, $comments, $imgReport, $idReport]);

if($stmt){
    echo "<script language='javascript' type='text/javascript'>alert('Reporte abandonado!'); window.location = ' ../visualizaReport.php?id=$idReport';</script>";
} else {
    echo "<script language='javascript' type='text/javascript'>alert('Não foi possível abandonar o reporte!'); window.location = ' ../visualizarReport.php?id=$idReport';</script>";
}

?>