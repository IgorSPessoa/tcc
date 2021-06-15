<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Conexão e configuração do banco de dados
include_once "../../configs/database.php";
$database = new Database();
$db = $database->getConnection();

// Instância do objeto de report
include_once "../../objects/report.php";
$report = new Report($db);

// Verifica e armazena campos
if(isset($_GET['id'])){
    $id = $_GET['id']; 
}else{
    // Define código de resposta como: 400 Bad Request
    http_response_code(400);     
    die(json_encode(array("message" => "missing_required_data")));
}

// Solicita todas a ONGs
$allReports = $report->getAllByUser($id);
if(count($allReports) >= 1){
    // Define código de resposta como: 200 Ok
    http_response_code(200);
    echo json_encode($allReports);
}else{
    // Define código de resposta como: 500 Internal Server Error
    http_response_code(404);
    echo json_encode(array("message" => "not_found"));   
}
?>
