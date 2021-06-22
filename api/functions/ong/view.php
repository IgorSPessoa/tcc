<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conexão e configuração do banco de dados
include_once "../../configs/database.php";
$database = new Database();
$db = $database->getConnection();

// Instância do objeto de ong
include_once "../../objects/ong.php";
$ong = new Ong($db);

// Recebe dados via POST - Body
$data = json_decode(file_get_contents("php://input"));

// Verifica e armazena campos
if(isset($data->id)){
    $id = $data->id;
}else{
    // Define código de resposta como: 400 Bad Request
    http_response_code(400);     
    die(json_encode(array("message" => "missing_required_data")));
}

// Lê o registro
$ong->LoadById($id);

if($ong->ong_id != null){
    // Popula o array
    $result = $ong->ongView();
    
    // Define código de resposta como: 200 Ok
    http_response_code(200);
    echo json_encode(array("message" => "sucess"));
}else{
    // Define código de resposta como: 404 Not Found
    http_response_code(404);
    echo json_encode(array("message" => "not_found"));   
}
?>
