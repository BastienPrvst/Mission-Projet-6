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
        try {
            $result = (new UserRepository())->createUser($pseudo, $email, $password);
            echo '<pre>';
            var_dump($result);
            echo '</pre>';
        }catch (Exception $e){
            echo $e->getMessage();
        }

    }

    public function logInPage() : void
    {
        $view = new View("Connexion");
        $view->render('loginForm');
    }

    public function logOut() : void
    {

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