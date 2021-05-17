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
$idOng = $_SESSION['id'];
$idReport = $_GET['id'];
$report_situacao = "waiting";
$imagemReport = "preview.jpg";

$sql = "UPDATE animal_report SET ong_id = ?, report_date_accepted = CURRENT_DATE(), report_situation = ?, report_img = ? WHERE id = ?";
$stmt = $mysql->prepare($sql);
 
$stmt->execute([$idOng, $report_situacao, $imagemReport, $idReport]);

if($stmt){
    echo "<script language='javascript' type='text/javascript'>alert('Reporte Aceito!'); window.location = ' ../visualizaReport.php?id=$idReport';</script>";
} else {
    echo "<script language='javascript' type='text/javascript'>alert('Não foi possível ingressar!'); window.location = ' ../visualizarReport.php?id=$idReport';</script>";
}

?>