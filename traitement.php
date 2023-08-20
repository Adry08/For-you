<?php

$chemin = './texte/';

$dossierJson = './data/';

$fichiers = (scandir($chemin));

foreach ($fichiers as $fichier) {

    if (in_array($fichier, ['.', '..'])) {
        continue;
    }
    $extension = strtolower(pathinfo($fichier, PATHINFO_EXTENSION));

    $size = formatTailleFichier(filesize($chemin.$fichier));

    $file[] = [
        "name" => $fichier, 
        "type" => $extension , 
        "size" => $size,
        "url" => $chemin.$fichier,
    ];

}

$jsonFile = json_encode($file , JSON_PRETTY_PRINT);

$cheminFichierJsonText = $dossierJson . 'jsonText.json';

if (!is_dir($dossierJson)) {
    mkdir($dossierJson, 0777, true);
}

file_put_contents($cheminFichierJsonText, $jsonFile);

function formatTailleFichier($taille)
{
    if ($taille >= 1048576) {
        return number_format($taille / 1048576, 2) . ' Mo';
    } elseif ($taille >= 1024) {
        return number_format($taille / 1024, 2) . ' ko';
    } else {
        return $taille . ' octets';
    }
}

?>

