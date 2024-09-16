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

    public function addBookForm() : void
    {
        $view = new View("Ajouter un livre");
        $view->render('addBook');
    }

    public function addBook() : void
    {
        $statut = filter_var(Utils::request('disponibility'), FILTER_VALIDATE_BOOLEAN);

        var_dump($_FILES);


        $book = new Book();
        $book->setTitle($_POST['title']);
        $book->setAuthor($_POST['author']);
        $book->setDescription($_POST['description']);
        $book->setUserId($_SESSION['user']['id']);
        $book->setStatut($statut);
        $book->setImage($_POST['picture']);
        $errors = (new BookRepository())->addBook($book);

        if ($errors !== null) {
            Utils::redirect("addBook", [
                "errors" => $errors
            ]);
        }

        $view = new View("Mon profil");
        $view->render('personalprofile');

    }

    public function deleteBook() : void
    {

    }

    public function updateBook() : void
    {

    }
}