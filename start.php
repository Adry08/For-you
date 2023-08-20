<?php

$base = './asset';

if (is_dir($base)){
    // start.php
    $file = ['./asset/texte.zip', './asset/images.zip'];

    foreach ($file as $i){

    $zip = new ZipArchive;

    $res = $zip->open($i);

    $zip->extractTo('./');
    $zip->close();

    }
}else{
    echo 'un dossier de depart manquant !';
    exit;
}

// Chemin vers le dossier cible public
$publicFolderPath = './images/public';

// Chemin vers le dossier cible privé
$privateFolderPath = './images/private';

// Extensions d'images autorisées
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

// Modèle de recherche des fichiers images
$imageSearchPattern = "%s/*.%s";

// Fonction pour compter les images dans un dossier
function countImagesInFolder($folderPath) {
    global $allowedExtensions, $imageSearchPattern;
    $imageCount = 0;
    foreach ($allowedExtensions as $extension) {
        $pattern = sprintf($imageSearchPattern, $folderPath, $extension);
        $imageCount += count(glob($pattern));
    }
    return $imageCount;
}

// Vérifier si les dossiers existent
if (is_dir($publicFolderPath) && is_dir($privateFolderPath)) {
    $publicImageCount = countImagesInFolder($publicFolderPath);
    $privateImageCount = countImagesInFolder($privateFolderPath);
    
    if ($publicImageCount > 0 || $privateImageCount > 0) {
        // Exécuter mimification.php
        exec('php mimification.php');
        exec('php traitement.php');
        echo "Le projet fonctionne";
    } else {
        echo "Les dossiers semblent être vides";
    }
} else {
    echo "Un ou plusieurs dossiers n'existent pas";
}
