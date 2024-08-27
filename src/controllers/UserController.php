<?php

class UserController
{

    public function registerForm() : void
    {

        $view = new View("S'inscrire");
        $view->render('registerForm');

    }

    public function registerUser() : void
    {
        $pseudo = Utils::request("register-pseudo");
        $email = Utils::request("register-email");
        $password = Utils::request("password");

        $result = (new UserRepository())->createUser($pseudo,$email ,$password);

        if ($result){
            Utils::redirect('registerForm',
            ['errors' => $result]);
        }else{
            Utils::redirect('loginForm',
                ['success' => 'Votre compte à bien été crée']);
        }
    }

    public function logInPage() : void
    {
        $view = new View("Connexion");
        $view->render('loginForm');
    }

    /**
     * @throws Exception
     */
    public function logInUser() : void
    {
        $email = Utils::request("email");
        $password = Utils::request("password");

        if ($email === null || $password === null) {
            return;
        }

        $user = (new UserRepository())->connectUser($email, $password);

        //Si aucun utilisateur avec ce mail ou mdp incorrect
        if ($user === false){
            Utils::redirect("loginForm",
                ['error' => 'Le pseudo et/ou le mot de passe est incorrect' ]);
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'pseudo' => $user->getPseudo(),
            'avatar' => $user->getAvatar(),
        ];

        Utils::redirect("personalProfile");
    }

    public function logOut() : void
    {
        unset($_SESSION['user']);

        Utils::redirect("home");
    }

    public function showPersonalProfile() : void
    {
        if (!isset($_SESSION['user'])){
            Utils::redirect("home");
        }

        $view = new View("Mon profil");
        $view->render('personalProfile');
    }

    public function modifiyUserInfo() : void
    {
        //Données du form
        $pseudo = Utils::request("user-pseudo");
        $email = Utils::request("user-email");
        $password = Utils::request("password");

        //Instanciation d'un USER avec les données de la session
        $user = new User();
        $user->setPseudo($_SESSION['user']['pseudo']);
        $user->setEmail($_SESSION['user']['email']);
        $user->setId($_SESSION['user']['id']);
        $user->setAvatar($_SESSION['user']['avatar']);

        $result = (new UserRepository())->updateUser($user, $pseudo, $email, $password);

        if ($result){
            $view = new View("Mon profil");
            $view->render('personalProfile',
                ['errors' => $result]);
        }else{
            $view = new View("Mon profil");
            $view->render('personalProfile',
                ['success' => true]);
        }

    }

    public function modifyAvatar() : void
    {
        $user = new User();
        $user->setPseudo($_SESSION['user']['pseudo']);
        $user->setEmail($_SESSION['user']['email']);
        $user->setId($_SESSION['user']['id']);
        $user->setAvatar($_SESSION['user']['avatar']);

        $errors = (new UserRepository())->updateAvatar($user);

        if (!empty($errors)){
            $view = new View("Mon profil");
            $view->render('personalProfile',
            ['errors' => $errors]);
        }

        //Redirection si pas d'erreurs dans le formulaire
        Utils::redirect("personalProfile");

    }

    public function showUserProfile() : void
    {
        $view = new View("Profil d'utilisateur");
        $view->render('userProfile');
    }
}