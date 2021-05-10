
<?php 
$host = 'mysql:host=localhost;dbname=tcc';
$user = 'root';
$pass = 'igor1337';

try{
    $mysql = new PDO($host, $user, $pass);
    $mysql ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo "Failed to connect to MySQL: " . $e->getMessage();
} catch (Exception $e){
    echo 'Do not enable to access: ' .$e->getMessage();
}
 
date_default_timezone_set('America/Sao_paulo'); 
?>