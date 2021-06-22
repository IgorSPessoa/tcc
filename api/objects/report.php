<?php
include_once "address.php";

class Report extends Address{
    private $conn;

    public $id;
    public $ong_id;
    public $author_id;
    public $animal_type;
    public $animal_description;
    public $animal_situation;
    public $animal_photo;
    public $report_created_data;
    public $location_cep;
    public $location_address;
    public $location_number;
    public $location_district;
    public $location_state;
    public $location_photo;
    public $location_observation;
    public $report_date_accepted;
    public $report_situation;
    public $report_img;

    // Construtor com $db como conexão
    public function __construct($db){
        $this->conn = $db;
    } 

    public function LoadById($id){
        // Construindo a query
        $query = "SELECT    ar.id,
                            ar.ong_id,
                            ar.animal_type, 
                            ar.animal_description, 
                            ar.animal_situation, 
                            ar.animal_photo,                            
                            a.location_cep, 
                            a.location_address, 
                            a.location_number, 
                            a.location_district, 
                            a.location_state, 
                            a.location_photo, 
                            a.location_observation, 
                            ar.report_created_data,
                            ar.report_situation,
                            ar.report_date_accepted,
                            ar.report_img
                        FROM animal_report ar
                            INNER JOIN address a ON (ar.address_id = a.id)
                        WHERE ar.id = :id";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $id = htmlspecialchars(strip_tags($id));

        // Atualizando os valores
        $stmt->bindParam(":id", $id);

        // Executando
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->ong_id = $row['ong_id'];
        $this->animal_type = $row['animal_type'];
        $this->animal_description = $row['animal_description'];
        $this->animal_situation = $row['animal_situation'];
        $this->animal_photo = $row['animal_photo'];
        $this->location_cep = $row['location_cep'];
        $this->location_address = $row['location_address'];
        $this->location_number = $row['location_number'];
        $this->location_district = $row['location_district'];
        $this->location_state = $row['location_state'];
        $this->location_photo = $row['location_photo'];
        $this->location_observation = $row['location_observation'];
        $this->report_created_data = $row['report_created_data'];
        $this->report_situation = $row['report_situation'];
        $this->report_date_accepted = $row['report_date_accepted'];
        $this->report_img = $row['report_img'];
        
        return True;        
    }

    public function getAllByUser($author_id){
         // Construindo a query
         $query = "SELECT   ar.id,
                    ar.ong_id,
                    ar.author_id,
                    ar.animal_type, 
                    ar.animal_description, 
                    ar.animal_situation, 
                    ar.animal_photo,                     
                    a.location_cep, 
                    a.location_address, 
                    a.location_number, 
                    a.location_district, 
                    a.location_state, 
                    a.location_photo, 
                    a.location_observation, 
                    ar.report_created_data,
                    ar.report_date_accepted,
                    ar.report_situation,
                    ar.report_date_accepted,
                    ar.report_img
                FROM animal_report ar
                        INNER JOIN address a ON (ar.address_id = a.id)
                    WHERE ar.author_id = :id";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $id = htmlspecialchars(strip_tags($author_id));

        // Atualizando os valores
        $stmt->bindParam(":id", $id);

        // Executando
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  

        return $rows;     
    }

    function createReport(){
        // Construindo a query
        $query = "INSERT INTO animal_report (author_id, address_id, animal_type, animal_description, animal_situation, animal_photo, report_created_data, report_date_accepted, report_situation, report_comments, report_img)
                        VALUES (:author_id, :address_id, :animal_type, :animal_description, :animal_situation, :animal_photo, current_date(), :report_date_accepted, :report_situation, :report_comments, :report_img);";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $this->author_id = (int)htmlspecialchars(strip_tags($this->author_id));
        $this->animal_type = htmlspecialchars(strip_tags($this->animal_type));
        $this->animal_description = htmlspecialchars(strip_tags($this->animal_description));
        $this->animal_situation = htmlspecialchars(strip_tags($this->animal_situation));
        $this->animal_photo = htmlspecialchars(strip_tags($this->animal_photo));
        $this->location_cep = htmlspecialchars(strip_tags($this->location_cep));
        $this->location_address = htmlspecialchars(strip_tags($this->location_address));
        $this->location_number = htmlspecialchars(strip_tags($this->location_number));
        $this->location_district = htmlspecialchars(strip_tags($this->location_district));
        $this->location_state = htmlspecialchars(strip_tags($this->location_state));
        $this->location_photo = htmlspecialchars(strip_tags($this->location_photo));
        $this->location_observation = htmlspecialchars(strip_tags($this->location_observation));
        $this->report_date_accepted = "0000-00-00";
        $this->report_situation = "pending";
        $this->report_comments = "";
        $this->report_img = ""; 

        // Preparando nome das imagens
        $name_animal_photo = $this->author_id . "_animal_photo_" . md5(time()) . ".jpeg";
        $name_location_photo = $this->author_id . "_location_photo_" . md5(time()) . ".jpeg";

        // Covertendo para jpeg e salvando
        $this->base64_to_jpeg($this->animal_photo, $name_animal_photo);
        $this->base64_to_jpeg($this->location_photo, $name_location_photo);

        // Gravando o endereço
        $address_id = $this->RecordAddress($this->conn, $this->location_cep, $this->location_address, $this->location_number, $this->location_district, $this->location_state, $name_location_photo, $this->location_observation);

        // Atualizando os valores
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->bindParam(":address_id", $address_id);
        $stmt->bindParam(":animal_type", $this->animal_type);
        $stmt->bindParam(":animal_description", $this->animal_description);
        $stmt->bindParam(":animal_situation", $this->animal_situation);
        $stmt->bindParam(":animal_photo", $name_animal_photo);
        $stmt->bindParam(":report_date_accepted", $this->report_date_accepted);
        $stmt->bindParam(":report_situation", $this->report_situation);
        $stmt->bindParam(":report_comments", $this->report_comments);
        $stmt->bindParam(":report_img", $this->report_img);
    
        // Executa a query
        if($stmt->execute()){
            return True;
        }
        
        print_r($stmt->errorInfo());
        return False;
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