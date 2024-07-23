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
        $pseudo = Utils::request("pseudo");
        $email = Utils::request("email");
        $password = Utils::request("password");

        $result = (new UserRepository())->createUser($pseudo, $email, $password);

        if ($result){
            $view = new View("S'inscrire");
            $view->render('registerForm',
                ['errors' => $result]);
        }else{
            $view = new View("Connexion");
            $view->render('loginForm',
                ['success' => true]);
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
        if (!$user){
            throw new Exception('Le mot de passe ou l\'adresse email est invalide');
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();
        $_SESSION['pseudo'] = $user->getPseudo();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['avatar'] = $user->getAvatar() ? : null;

        Utils::redirect("home");
    }

    public function logOut() : void
    {
        unset($_SESSION['user']);
        unset($_SESSION['idUser']);
        unset($_SESSION['pseudo']);
        unset($_SESSION['email']);
        unset($_SESSION['avatar']);

        Utils::redirect("home");
    }

    public function showPersonalProfile() : void
    {
        $view = new View("Mon profil");
        $view->render('personalProfile');
    }

    public function showUserProfile() : void
    {
        $view = new View("Profil d'utilisateur");
        $view->render('userProfile');
    }
}