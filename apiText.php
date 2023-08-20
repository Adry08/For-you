<?php
session_start();

if($_SESSION['user'] !== 'public'){
    $way = './data/jsonText.json';


$data = file_get_contents($way);

$jsonData = $data;


header('Content-Type: application/json');
echo $jsonData;

}

?>