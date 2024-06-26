<h1>Message bien reçu !</h1>
<?php

$postData = $_POST;

if (
    !isset($postData['email'])
    || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)
    || empty($postData['message'])
    || trim($postData['message']) === ''
) {
    echo('Il faut un email et un message valides pour soumettre le formulaire.');
    return;
}
$postData = $_POST;


$isFileLoaded = false;
// Testons si le fichier a bien été envoyé et s'il n'y a pas des erreurs
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === 0) {
    // Testons, si le fichier est trop volumineux
    if ($_FILES['screenshot']['size'] > 1000000) {
        echo "L'envoi n'a pas pu être effectué, erreur ou image trop volumineuse";
        return;
    }

    // Testons, si l'extension n'est pas autorisée
    $fileInfo = pathinfo($_FILES['screenshot']['name']);
    $extension = $fileInfo['extension'];
    $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
    if (!in_array($extension, $allowedExtensions)) {
        echo "L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisée";
        return;
    }

    // Testons, si le dossier uploads est manquant
    $path = __DIR__ . '/uploads/';
    if (!is_dir($path)) {
        echo "L'envoi n'a pas pu être effectué, le dossier uploads est manquant";
        return;
    }

    // On peut valider le fichier et le stocker définitivement
    move_uploaded_file($_FILES['screenshot']['tmp_name'], $path . basename($_FILES['screenshot']['name']));
    $isFileLoaded = true;
}
?>
        
<div class="card">
    
    <div class="card-body">
        <h5 class="card-title">Rappel de vos informations</h5>
        <p class="card-text"><b>Email</b> : <?php echo $postData['email']; ?></p>
        <p class="card-text"><b>Message</b> : <?php echo(strip_tags($postData['message'])) ; ?></p>
    </div>
</div>
