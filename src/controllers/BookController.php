<?php

class BookController{

    public function showHome() : void
    {
        $view = new View("Accueil");
        $view->render('home');
    }

    public function showBookList() : void
    {
        $view = new View("Nos livres à l'échange");
        $view->render('bookList');
    }

    public function showBookDetail() : void
    {
        $view = new View("Livre");
        $view->render('bookDetail');
    }

    public function addBook() : void
    {

    }

    public function deleteBook() : void
    {

    }

    public function updateBook() : void
    {

    }
}