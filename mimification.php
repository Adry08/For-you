<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

$dossierPublic = './images/public/';
$dossierPrivate = './images/private/';

$dossierPublicTraitees = './images/public_traites/';
$dossierPrivateTraitees = './images/private_traites/';
$dossierJson = './data/';

// Créer les répertoires s'ils n'existent pas

if (!is_dir($dossierPublicTraitees)) {
    mkdir($dossierPublicTraitees, 0777, true);
}
if (!is_dir($dossierPrivateTraitees)) {
    mkdir($dossierPrivateTraitees, 0777, true);
}

Image::configure(array('driver' => 'gd'));

$qualiteCompression = 80; // Ajustez la qualité de compression si nécessaire (0-100)

$donneesImagesPublic = [];
$donneesImagesPrivate = [];
$formatsSupportes = ['jpeg', 'jpg', 'png', 'gif'];

foreach (['public', 'private'] as $type) {
    $dossierImagesType = ($type === 'public') ? $dossierPublic : $dossierPrivate;
    $dossierTraiteesType = ($type === 'public') ? $dossierPublicTraitees : $dossierPrivateTraitees;

    $fichiersImages = scandir($dossierImagesType);

    foreach ($fichiersImages as $fichier) {
        if (in_array($fichier, ['.', '..'])) {
            continue;
        }

        $extension = strtolower(pathinfo($fichier, PATHINFO_EXTENSION));

        if (!in_array($extension, $formatsSupportes)) {
            continue;
        }

        $cheminImage = $dossierImagesType . $fichier;

        $image = Image::make($cheminImage);

        // Obtenir les dimensions originales
        $largeurOriginale = $image->width();
        $hauteurOriginale = $image->height();

        // Déterminer si un redimensionnement est nécessaire en fonction des dimensions
        if ($largeurOriginale > 300 || $hauteurOriginale > 300) {
            // Calculer les nouvelles dimensions tout en maintenant le rapport d'aspect
            $nouvelleLargeur = 300; // Vous pouvez ajuster cette valeur
            $nouvelleHauteur = intval($hauteurOriginale * ($nouvelleLargeur / $largeurOriginale));

            // Redimensionner l'image sans compression
            $imageTraitee = $image->resize($nouvelleLargeur, $nouvelleHauteur, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            // Compresser l'image de 50%
            $imageTraitee = $image->resize($largeurOriginale * 0.5, $hauteurOriginale * 0.5)->encode($extension, $qualiteCompression);
        }

        // Enregistrer l'image traitée dans le dossier approprié
        $cheminImageTraitee = $dossierTraiteesType . 'traitee_' . $fichier;
        $imageTraitee->save($cheminImageTraitee);

        // Modifier l'URL de l'image traitée en conséquence
        $urlImageTraitee = $dossierTraiteesType . 'traitee_' . $fichier;
        $urlImageTraitee = str_replace($_SERVER['DOCUMENT_ROOT'], '', $urlImageTraitee);
        $urlImageTraitee = ltrim($urlImageTraitee, '/');

        // Collecter les données sur l'image traitée
        $dateModification = date('Y-m-d H:i:s', filemtime($cheminImage));
        $dateCreation = date('Y-m-d H:i:s', filectime($cheminImage));
        $tailleFichierOriginal = filesize($cheminImage);
        $tailleFichierFormatee = formatTailleFichier($tailleFichierOriginal);
        $tailleFichierTraitee = filesize($cheminImageTraitee);
        $tailleFichierTraiteeFormatee = formatTailleFichier($tailleFichierTraitee);

        // Créer un tableau avec les données de l'image
        $donneesImage = [
            'id' => md5($cheminImage),
            'url_originale' => $cheminImage,
            'taille_originale' => $tailleFichierFormatee,
            'url_traitee' => $urlImageTraitee,
            'taille_traitee' => $tailleFichierTraiteeFormatee,
            'date' => $dateModification ? $dateModification : $dateCreation,
            'format_original' => $extension,
        ];

        // Ajouter les données à l'array approprié en fonction du type
        if ($type === 'public') {
            $donneesImagesPublic[] = $donneesImage;
        } else {
            $donneesImagesPrivate[] = $donneesImage;
        }
    }
}

// Convertir le tableau de données en format JSON
$jsonDonneesPublic = json_encode($donneesImagesPublic, JSON_PRETTY_PRINT);
$jsonDonneesPrivate = json_encode($donneesImagesPrivate, JSON_PRETTY_PRINT);

// Enregistrer le JSON dans un fichier
$cheminFichierJsonPublic = $dossierJson . 'jsonPublic.json';
$cheminFichierJsonPrivate = $dossierJson . 'jsonPrivate.json';

if (!is_dir($dossierJson)) {
    mkdir($dossierJson, 0777, true);
}

file_put_contents($cheminFichierJsonPublic, $jsonDonneesPublic);
file_put_contents($cheminFichierJsonPrivate, $jsonDonneesPrivate);

// Afficher un message de confirmation
echo "Les données ont été enregistrées dans les fichiers JSON : $cheminFichierJsonPublic et $cheminFichierJsonPrivate";

// Fonction pour formater la taille du fichier
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
