<?php

class UserController
{

    public function registerPage() : void
    {

        $view = new View("S'inscrire");
        $view->render('register');

    }

    public function logInPage() : void
    {
        $view = new View("Connexion");
        $view->render('login');
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