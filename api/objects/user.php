<?php

class Usuario{
    private $conn;
 
    public $id;
    public $name;
    public $email; 
    public $pwd; 
    public $img;
    public $phone; 
    public $cep; 
    public $created_at; 
    public $reports;

    // Construtor com $db como conexão
    public function __construct($db){
        $this->conn = $db;
    } 

    function createUser(){
        // Construindo a query
        $query = "INSERT INTO user (name, email, pwd, img, phone, cep, created_at) 
                                VALUES(:name, :email, :pwd, :img, :phone, :cep, :created_at)";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->pwd = htmlspecialchars(strip_tags($this->pwd));
        $this->img = htmlspecialchars(strip_tags($this->img));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->cep = htmlspecialchars(strip_tags($this->cep));
        $this->created_at = date('Y-m-d');

        // Atualizando os valores
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pwd", $this->pwd);
        $stmt->bindParam(":img", $this->img);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":cep", $this->cep);
        $stmt->bindParam(":created_at", $this->created_at);

        // Executa a query
        if($stmt->execute()){
            return True;
        }
        
        print_r($stmt->errorInfo()); 

        return False;
    }

    function loginUser(){
        // Construindo a query
        $query = "SELECT *, (SELECT count(*) reports FROM animal_report ar WHERE ar.author_id = u.id) send_reports
                            FROM user u WHERE email = :email LIMIT 1";

        // Preparando a query
        $stmt = $this->conn->prepare($query);
        
        // Atualizando os valores
        $stmt->bindParam("email", $this->email);

        // Executa a query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->img = $row['img'];
        $this->pwd = $row['pwd'];
        $this->phone = $row['phone']; 
        $this->cep = $row['cep']; 
        $this->created_at = $row['created_at']; 
        $this->reports = $row['send_reports']; 
    }

    function IsAvailableEmail(){
        // Construindo a query
        $query = "SELECT email FROM user WHERE email = :email;";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Atualizando os valores
        $stmt->bindParam(":email", $this->email);

        // Executando
        $stmt->execute();

        // Pegando o número de linhas
        $count = $stmt->rowCount();

        // Retorna true se estiver disponivel ou false se tiver indisponivel
        return $count == 0;
    }

    function getProfile(){
        // Construindo a query
        $query = "SELECT u.*, (SELECT count(*) reports FROM animal_report ar WHERE ar.author_id = u.id) send_reports
                    FROM user u WHERE u.email = :email;";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Atualizando os valores
        $stmt->bindParam(":email", $this->email);

        // Executando
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->pwd = $row['pwd'];
        $this->img = $row['img'];
        $this->phone = $row['phone']; 
        $this->cep = $row['cep']; 
        $this->created_at = $row['created_at']; 
        $this->reports = $row['send_reports']; 
        
        return True;
    }

    function updatePassword($newPwd){
        // Construindo a query
        $query = "UPDATE user SET pwd = :pwd WHERE email = :email;";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $this->email = htmlspecialchars(strip_tags($this->email));
        $newPwd = htmlspecialchars(strip_tags($newPwd));

        // Pegando o resultado
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pwd", $newPwd);

        // Executa a query
        if($stmt->execute()){
            return True;
        }

        return False;
    }

    function updateInfos($phone, $cep){
        // Construindo a query
        $query = "UPDATE user SET phone = :phone, cep = :cep WHERE email = :email;";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $this->email = htmlspecialchars(strip_tags($this->email));
        $phone = htmlspecialchars(strip_tags($phone));
        $cep = htmlspecialchars(strip_tags($cep));

        // Atualizando valores da query
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":cep", $cep);

        // Executa a query
        if($stmt->execute()){
            return True;
        }

        return False;
    }

    function updateAvatar($base64_img){
        // Deletando avatar antigo
        $this->deleteAvatar($this->email);

        // Preparando nome da imagem
        $ext = ".jpeg";
        $nameUser = strstr($this->email, '@', TRUE);
        $name_of_new_avatar = time() . md5($nameUser) . $ext;

        // Covertendo para jpeg e salvando
        $this->base64_to_jpeg($base64_img, $name_of_new_avatar);

        // Construindo a query
        $query = "UPDATE user SET img = :photo_name WHERE email = :email";

        // Preparando a query
        $stmt = $this->conn->prepare($query);     
        
        // Atualizando valores da query
        $stmt->bindParam(":photo_name", $name_of_new_avatar);
        $stmt->bindParam(":email", $this->email);

        // Executa a query
        if($stmt->execute()){
            return True;
        }

        return False;
    }

    function deleteAvatar(){
        // Construindo a query
        $query = "SELECT img FROM user WHERE email = :email";

        // Preparando a query
        $stmt = $this->conn->prepare($query);     
        
        // Atualizando valores da query
        $stmt->bindParam(":email", $this->email);

        // Executando
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $fileName = $row['img'];    
        
        $upload_path = "../../../imgsUpdate";
        if(file_exists("$upload_path/$fileName") && $fileName != 'preview.jpg'){
            unlink("$upload_path/$fileName"); //Tirando a imgagem do diretorio   
        }
    }

    function base64_to_jpeg($base64_string, $output_file) {
        $upload_path = "../../../imgsUpdate";
        $base64_code = $base64_string;
        
        $fp = fopen("$upload_path/$output_file", "w+");
        fwrite($fp, base64_decode($base64_code));
        fclose($fp);
    }
}


?>