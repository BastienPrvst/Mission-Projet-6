<?php

class BookController{

    /**
     * @throws Exception
     */
    public function showHome() : void
    {
        $lastBooks = (new BookRepository())->findLastBooks();
        $view = new View("Accueil");
        $view->render("home",
            ['lastBooks' => $lastBooks]);
    }

    public function showBookList(?int $limit = 10000) : void
    {
        $allBooks = (new BookRepository())->findBooks($limit);
        $view = new View("Nos livres à l'échange");
        $view->render('bookList',
            ['books' => $allBooks]
        );
    }

    public function showBookDetail() : void
    {
        $view = new View("Livre");
        $view->render('bookDetail');
    }

    public function addBook() : void
    {
        $view = new View("Ajouter un livre");
        $view->render('addBook');
    }

    public function deleteBook() : void
    {

    }

    public function updateBook() : void
    {

    }
}