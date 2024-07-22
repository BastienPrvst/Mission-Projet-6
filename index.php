<?php
require_once 'config/config.php';
require_once 'config/autoload.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
$action = Utils::request('action', 'home');

// Try catch global pour gérer les erreurs
try {
// Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages BookController.
        case 'home':
            (new BookController())->showHome();
            break;
        case 'bookList':
            (new BookController())->showBookList();
            break;
        case 'bookDetail':
            (new BookController())->showBookDetail();
            break;
        case 'addBook':
            (new BookController())->addBook();
            break;
        // Pages User Controller
        case 'registerForm':
            (new UserController())->registerForm();
            break;
        case 'registerUser':
            (new UserController())->registerUser();
            break;
        case 'loginForm' :
            (new UserController())->logInPage();
            break;
        case 'personnalProfile' :
            (new UserController())->showPersonalProfile();
            break;
        case 'userProfile' :
            (new UserController())->showUserProfile();
            break;
        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
// En cas d'erreur, on affiche la page d'erreur.
$errorView = new View('Erreur');
$errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}