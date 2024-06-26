<?php
session_start();
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$postData = $_POST;

// Validation du formulaire
if (isset($postData['email']) && isset($postData['password'])) {
    if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire.';
    } else {
        $userFound = false;
        foreach ($users as $user) {
            if ($user['email'] === $postData['email'] && $user['password'] === $postData['password']) {
                $_SESSION['LOGGED_USER'] = [
                    'email' => $user['email'],
                    'user_id' => $user['user_id'],
                ];
                $userFound = true;
                break; // On arrête la boucle dès que l'utilisateur est trouvé
            }
        }

        if (!$userFound) {
            $_SESSION['LOGIN_ERROR_MESSAGE'] = sprintf(
                'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
                htmlspecialchars($postData['email'], ENT_QUOTES, 'UTF-8'),
                strip_tags($postData['password'])
            );
        }
    }

    redirectToUrl('index.php');
}
?>
