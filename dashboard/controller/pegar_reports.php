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

//Conectando com o servidor mysql
include '../../connect.php';

//pegando as variaveis
$tipo = $_GET["report"];
$ong_id = $_GET["id"];
$origins = "";
$destinations = "";

if($tipo == "all"){
    //Pegando conteúdo do banco de dados e colocando na variavel
    $sqlscd = $mysql->prepare("SELECT a.location_cep FROM ong o INNER JOIN address a ON (o.address_id = a.id) WHERE o.id = ?;");
    $sqlscd->execute([$ong_id]);
    while($linha = $sqlscd->fetch(PDO::FETCH_ASSOC)){
        $origins = "$linha[location_cep]";
    }

    $sql = $mysql->prepare("SELECT ar.*, 
                                      a.location_address, 
                                      a.location_number,
                                      a.location_district,
                                      a.location_state,
                                      a.location_cep
                                    FROM animal_report ar INNER JOIN address a ON (ar.address_id = a.id) WHERE report_situation = 'pending';");
    $sql->execute();
    //criando um array principal
    $reports = [];

    //criando o array secundario 
    $report = [];

    while($linha = $sql->fetch(PDO::FETCH_BOTH)){
        //variaveis de controle
        $destinations = $linha['location_cep'];
        $tipo = $linha[4];

        //traduzindo os dados
        if($tipo == "dog"){
            $tipo = "Cachorro";
        } elseif($tipo == "cat"){
            $tipo = "Gato";
        } elseif( $tipo == "others"){
            $tipo = "Outros";
        }

        // Localização
        $localizacao = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";
        
        //url da api retornando o arquivo desejado
        $distance_data = file_get_contents(
            'https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.urlencode($origins).'&destinations='.urlencode($destinations).'&region=br&key=AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo'
        );
        
        //transformando o objeto resultante em JSON
        $distance_arr = json_decode($distance_data);
    
        //Pegando os status do resultado da distância
        $validation = $distance_arr->rows[0]->elements[0]->status;

        //validando os status
        if($validation != "OK"){
            //traduzindo os status da mensagem
            if($validation == "NOT_FOUND"){
                $validation = "Não encontrado";
            } elseif($validation == "ZERO_RESULTS"){
                $validation = "Zero resultado";
            } elseif($validation == "MAX_ROUTE_LENGTH_EXCEEDED"){
                $validation = "Rota excedida";
            }
             //validando a distâancia
             $distancia = $validation;
  
             //definindo o report
             $report = [];
 
             //colocando os resultados dentro do array
             $report[] = $linha[0];
             $report[] = $tipo;
             $report[] = $linha[5];
             $report[] = $localizacao;
             $report[] = $distancia;
 
             $reports[] = $report;
        } else {
            //localizando a distâancia
            $distancia = $distance_arr->rows[0]->elements[0]->distance->text;

            //definindo o report
            $report = [];

            //colocando os resultados dentro do array
            $report[] = $linha[0];
            $report[] = $tipo;
            $report[] = $linha[5];
            $report[] = $localizacao;
            $report[] = $distancia;

            $reports[] = $report;
        }
    }
} else {
    //Pegando conteúdo do banco de dados e colocando na variavel
    $sqlscd = $mysql->prepare("SELECT a.location_cep FROM ong o INNER JOIN address a ON (o.address_id = a.id) WHERE o.id = ?;");
    $sqlscd->execute([$ong_id]);
    while($linha = $sqlscd->fetch(PDO::FETCH_ASSOC)){
        $origins = "$linha[location_cep]";
    }

    //query para pegar dados do report e onde ela está localizada
    $sql = $mysql->prepare("SELECT ar.*,
                                   a.location_address, 
                                   a.location_number,
                                   a.location_district,
                                   a.location_state,
                                   a.location_cep FROM animal_report ar INNER JOIN address a ON (ar.address_id = a.id) 
                                WHERE NOT( report_situation = 'rescued' OR report_situation = 'not_found') AND ong_id = ?;");
    $sql->execute([$ong_id]);

    //criando um array principal
    $reports = [];

    //criando o array secundario 
    $report = [];

    while($linha = $sql->fetch(PDO::FETCH_BOTH)){
        //variaveis de controle
        $destinations = $linha['location_cep'];
        $tipo = $linha[4];

        //traduzindo os dados
        if($tipo == "dog"){
            $tipo = "Cachorro";
        } elseif($tipo == "cat"){
            $tipo = "Gato";
        } elseif( $tipo == "others"){
            $tipo = "Outros";
        }

        // Localização
        $localizacao = "$linha[location_address] $linha[location_number], $linha[location_district], $linha[location_state]";

        //url da api retornando um arquivo
        $distanceData = file_get_contents(
            'https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.urlencode($origins).'&destinations='.urlencode($destinations).'&region=br&&key=AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo'
        );

        //transformando o objeto resultante em JSON
        $distance_arr = json_decode($distanceData);

        //Pegando os status do resultado da distância
        $validation = $distance_arr->rows[0]->elements[0]->status;

        //validando os status
        if($validation != "OK"){
            //traduzindo os status da mensagem
            if($validation == "NOT_FOUND"){
                $validation = "Não encontrado";
            } elseif($validation == "ZERO_RESULTS"){
                $validation = "Zero resultado";
            } elseif($validation == "MAX_ROUTE_LENGTH_EXCEEDED"){
                $validation = "Rota excedida";
            }
             //validando a distâancia
             $distancia = $validation;
  
             //definindo o report
             $report = [];
 
             //colocando os resultados dentro do array
             $report[] = $linha[0];
             $report[] = $tipo;
             $report[] = $linha[5];
             $report[] = $localizacao;
             $report[] = $distancia;
 
             $reports[] = $report;
        } else {

            //localizando a distâancia e validando a kilometragem
            $distancia = $distance_arr->rows[0]->elements[0]->distance->text;
            
            //definindo o report
            $report = [];

            //colocando os resultados dentro do array
            $report[] = $linha[0];
            $report[] = $tipo;
            $report[] = $linha[5];
            $report[] = $localizacao;
            $report[] = $distancia;

            $reports[] = $report;
        }
    }
}
//Converte o conteúdo para ser lido como um json
header('Content-Type: application/json');
echo json_encode($reports); 

?>