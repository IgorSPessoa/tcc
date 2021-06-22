<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 

// Conexão e configuração do banco de dados
include_once "../../configs/database.php";
$database = new Database();
$db = $database->getConnection();

// Instancia do objeto de usuário
include_once "../../objects/user.php";
$user = new Usuario($db); 

// Recebe dados via PUT - Body
$data = json_decode(file_get_contents("php://input"));

// Verifica e armazena dados
if(isset($data->email, $data->pwd, $data->new_avatar)){
    $user->email = $data->email;
    $data_pwd = md5($data->pwd);
}else{
    // Define código de resposta como: 400 Bad Request
    http_response_code(400);   
    die(json_encode(array("message" => "missing_required_data"))); 
}

// Lê o registro
$user->loginUser();

if($user->id != null){
    // Verificando se a senha está correta
    if($user->pwd == $data_pwd){
        $result = $user->updateAvatar($data->new_avatar);
        if($result){
            // Define código de resposta como: 200 Ok
            http_response_code(200);
            echo json_encode(array("message" => "successful_change"));           
        }else{
            // Define código de resposta como: 500 Internal Server Error
            http_response_code(500);       
            echo json_encode(array("message" => "internal_error"));
        }
    }else{
        // Define código de resposta como: 401 Unauthorized
        http_response_code(401);
        echo json_encode(array("message" => "invalid_authentication"));
    }
}else{
    // Define código de resposta como: 404 Not Found
    http_response_code(404);
    echo json_encode(array("message" => "not_found"));   
}
?>