<?php

class Address{
    public $location_cep;
    public $location_address;
    public $location_number;
    public $location_district;
    public $location_state;
    public $location_photo;
    public $location_observation;

    public function RecordAddress($conn, $location_cep, $location_address, $location_number, $location_district, $location_state, $location_photo, $location_observation){
        // Construindo a query
        $query = "INSERT INTO   ADDRESS  (location_cep, location_address, location_number, location_district, location_state, location_photo, location_observation)
                                VALUES (:location_cep, :location_address, :location_number, :location_district, :location_state, :location_photo, :location_observation);";

        // Preparando a query
        $stmt = $conn->prepare($query);

        // Limpando a query;
        $this->location_cep = htmlspecialchars(strip_tags($location_cep));
        $this->location_address = htmlspecialchars(strip_tags($location_address));
        $this->location_number = htmlspecialchars(strip_tags($location_number));
        $this->location_district = htmlspecialchars(strip_tags($location_district));
        $this->location_state = htmlspecialchars(strip_tags($location_state));
        $this->location_photo = htmlspecialchars(strip_tags($location_photo));
        $this->location_observation = htmlspecialchars(strip_tags($location_observation));

        // Atualizando os valores
        $stmt->bindParam(":location_cep", $this->location_cep);
        $stmt->bindParam(":location_address", $this->location_address);
        $stmt->bindParam(":location_number", $this->location_number);
        $stmt->bindParam(":location_district", $this->location_district);
        $stmt->bindParam(":location_state", $this->location_state);
        $stmt->bindParam(":location_photo", $this->location_photo);
        $stmt->bindParam(":location_observation", $this->location_observation);

        // Executa a query
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
        }

        $address_id = $conn->lastInsertId();
        return (int)$address_id;        
    }


}

 
?>