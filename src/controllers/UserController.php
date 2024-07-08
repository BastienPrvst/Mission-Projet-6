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

    }

    public function showUserProfile() : void
    {

    }
}