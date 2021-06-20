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

//query de vincular o report com a ONG
$sql = "UPDATE animal_report SET ong_id = ?, report_date_accepted = CURRENT_DATE(), report_situation = ?, report_img = ? WHERE id = ?";

//preparando a query
$stmt = $mysql->prepare($sql);
 
//executando a query
$stmt->execute([$idOng, $report_situacao, $imagemReport, $idReport]);

//verificando se o resultado da query foi verdadeiro 
if($stmt){//se sim, cairá aqui
    header('Location: ../visualizaReport.php?id=' . $idReport . '&msg=sucess_acceptedReport');
} else{//se não, cairá aqui
    header('Location: ../visualizaReport.php?id=' . $idReport . '&msg=error_acceptedReport');
}

?>