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
        $allBooks = (new BookRepository())->findAvailableBooks();
        $view = new View("Nos livres à l'échange");
        $view->render('bookList',
            ['books' => $allBooks]
        );
    }

    public function showBookDetail() : void
    {
        $bookId = Utils::request('id');
        $book = (new BookRepository())->findBookById($bookId);
        $user = (new UserRepository())->getUserById($book->getUserId());
        if (!$user){
            Utils::redirect('bookList');
        }
        $view = new View("Livre");
        $view->render('bookDetail',
        ['book' => $book,
         'user' => $user]);
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

    public function updateBook() : void
    {

        $idBook = (int)Utils::request("id");

        $book = new Book();

        $book->setTitle(Utils::request("title"));
        $book->setAuthor(Utils::request("author"));
        $book->setDescription(Utils::request("description"));
        $book->setStatut(Utils::request("disponibility"));

        $errors = (new BookRepository())->updateBook($idBook, $book);

        if (!empty($errors)){
            Utils::redirect("updateBook", [
                "errors" => $errors
            ]);
        }

        Utils::redirect('personalProfile');

    }

    public function searchBook()
    {
        $keyword = Utils::request("keyword");
        $result = (new BookRepository())->findBooksByKeyword($keyword);
        $view = new View("Liste des livres");
        $view->render("bookList",[
            'result' => $result
        ]);
    }

}