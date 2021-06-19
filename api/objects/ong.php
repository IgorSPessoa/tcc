<?php

class Ong{
     private $conn;

    public $ong_id;
    public $ong_name;
    public $ong_description;
    public $ong_email;
    public $ong_purpose; 
    public $ong_phone;
    public $ong_opening_date; 
    public $ong_business_hours;
    public $ong_img;
    public $ong_rescue_count;
    public $ong_adoptions_count;
    public $ong_view;
    public $location_cep;
    public $location_address;
    public $location_number;
    public $location_district;
    public $location_state;

    // Construtor com $db como conexão
    public function __construct($db){
        $this->conn = $db;
    } 

    public function LoadById($id){
        // Construindo a query
        $query = "SELECT    o.id,
                            o.ong_name,
                            o.ong_description, 
                            o.ong_email, 
                            o.ong_purpose, 
                            o.ong_phone, 
                            o.ong_opening_date, 
                            o.ong_business_hours, 
                            o.ong_img, 
                            o.ong_view,
                            a.location_cep, 
                            a.location_address, 
                            a.location_number, 
                            a.location_district,
                            a.location_state,
                            (SELECT count(report_situation) FROM animal_report ar WHERE ar.report_situation = 'rescued' AND ar.ong_id = o.id) as ong_rescue_count, 
                            (SELECT count(adoption_situation) FROM animal_adoption ad WHERE ad.adoption_situation = 'adopted' AND ad.ong_id = o.id) as ong_adoptions_count
                                FROM ong o
                                    INNER JOIN address a ON (o.address_id = a.id)
                                WHERE o.id = :id";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando a query;
        $id = htmlspecialchars(strip_tags($id));

        // Atualizando os valores
        $stmt->bindParam(":id", $id);

        // Executando
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->ong_id = $row['id'];
        $this->ong_name = $row['ong_name'];
        $this->ong_description = $row['ong_description'];
        $this->ong_email = $row['ong_email'];
        $this->ong_purpose = $row['ong_purpose'];
        $this->ong_phone = $row['ong_phone'];
        $this->ong_opening_date = $row['ong_opening_date'];
        $this->ong_business_hours = $row['ong_business_hours'];
        $this->ong_img = $row['ong_img'];
        $this->location_cep = $row['location_cep'];
        $this->location_address = $row['location_address'];
        $this->location_number = $row['location_number'];
        $this->location_district = $row['location_district'];
        $this->location_state = $row['location_state'];
        $this->ong_rescue_count = $row['ong_rescue_count'];
        $this->ong_adoptions_count = $row['ong_adoptions_count'];
        $this->ong_view = $row['ong_view'];
        
        return True;        
    }

    public function getAll(){
         // Construindo a query
         $query = "SELECT   o.id,
                            o.ong_name,
                            o.ong_description, 
                            o.ong_email, 
                            o.ong_purpose, 
                            o.ong_phone, 
                            o.ong_opening_date, 
                            o.ong_business_hours, 
                            o.ong_img, 
                            o.ong_view,
                            a.location_cep, 
                            a.location_address, 
                            a.location_number, 
                            a.location_district,
                            a.location_state,
                            (SELECT count(report_situation) FROM animal_report ar WHERE ar.report_situation = 'rescued' AND ar.ong_id = o.id) as ong_rescue_count, 
                            (SELECT count(adoption_situation) FROM animal_adoption ad WHERE ad.adoption_situation = 'adopted' AND ad.ong_id = o.id) as ong_adoptions_count                                FROM ong o
                                    INNER JOIN address a ON (o.address_id = a.id);";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Executando
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        return $rows;     
    }
    
    public function ongView(){
        // Construindo a query
        $query = "UPDATE ong SET ong_view = ong_view + 1 WHERE id = :id";

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Atualizando os valores
        $stmt->bindParam(":id", $this->ong_id);

        // Executando
        $result = $stmt->execute();

        return $result;             
    }

}


?>