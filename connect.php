<?php
$mysql = new mysqli('localhost', 'root', 'igor1337', 'tcc');
$mysql->set_charset("utf8");

if ($mysql -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysql -> connect_error;
    exit();
}

date_default_timezone_set('America/Sao_paulo'); 
?>