<?php

session_start();
// session_destsroy();

if($_SESSION['user'] !== 'public'){
    $way = './data/jsonPrivate.json';
}else{
    $way = './data/jsonPublic.json';
}


if(isset($_SESSION['last_request'])) {
    $lastRequest = $_SESSION['last_request'];
} else {
    $lastRequest = 0;
    $_SESSION['last_request'] = $lastRequest;
}

$requet = $_GET['a'];


$_SESSION['last_request'] = $_SESSION['last_request'] + $_GET['a'] + 1;


// echo $_SESSION['last_request'];
// session_reset();

// echo $requet;

// session_reset();


$data = file_get_contents($way);

$contenu_fichier = json_decode($data, JSON_PRETTY_PRINT);

$i = $lastRequest;
$j = $i + $requet;

$imageData=[];
for($i; $i <= $j ; $i++){
    if($i >= count($contenu_fichier)){
        $j = $j - $i;
        $_SESSION['last_request'] = $j + 1;
        $i = 0 ;
        $imageData[] = $contenu_fichier[$i];
    }else{
        $imageData[] = $contenu_fichier[$i];
    }
}

$jsonData = json_encode($imageData, JSON_PRETTY_PRINT);

header('Content-Type: application/json');
echo $jsonData;


?>