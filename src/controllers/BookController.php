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

        $book = new Book();
        $book->setTitle(Utils::request("title"));
        $book->setAuthor(Utils::request("author"));
        $book->setDescription(Utils::request("description"));
        $book->setUserId($_SESSION['user']['id']);
        $book->setStatut($statut);
        $errors = (new BookRepository())->addBook($book);

        if ($errors !== null) {
            Utils::redirect("addBook", [
                "errors" => $errors
            ]);
        }

        Utils::redirect("personalProfile");
    }

    public function deleteBook() : void
    {
        $idBook = (int)Utils::request("id");
        $idUser = (int)Utils::request("userId");
        if($idUser === $_SESSION['user']['id']){
            (new BookRepository())->deleteBookById($idBook,$idUser);
        }
        Utils::redirect("personalProfile");

    }

    public function updateBookForm() : void
    {
        $idBook = (int)Utils::request("id");
        $userId = (int)Utils::request("userId");
        if($userId === $_SESSION['user']['id']){

            $book = (new BookRepository())->findBookById($idBook);

            $view = new View("Modifier un livre");
            $view->render("updateBook",
            ['book' => $book]);
        } else {
            Utils::redirect("home");
        }
    }
}