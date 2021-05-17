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

$sql = "UPDATE animal_report SET ong_id = 0, report_date_accepted = 0000-00-00, report_situation = 'pending' report_comments = '', report_img = 'preview.jpg' WHERE id = ?";
$stmt = $mysql->prepare($sql);
 
$stmt->execute([$idReport]);

if($stmt){
    echo "<script language='javascript' type='text/javascript'>alert('Reporte abandonado!'); window.location = ' ../visualizaReport.php?id=$idReport';</script>";
} else {
    echo "<script language='javascript' type='text/javascript'>alert('Não foi possível abandonar o reporte!'); window.location = ' ../visualizarReport.php?id=$idReport';</script>";
}

?>