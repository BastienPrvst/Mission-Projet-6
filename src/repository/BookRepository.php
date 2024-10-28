<?php


class BookRepository extends AbstractEntityManager
{
    public function findBooks(?int $limit = 10000) : PDOStatement
    {
        try {
            $sql = <<<EOD
            SELECT b.* , u.pseudo
            FROM books b
            INNER JOIN users u ON u.id = b.user_id
            ORDER BY b.id DESC
            LIMIT $limit;
            EOD;

            return $this->db->query($sql);


        }catch (Exception $exception){

            exit(0);
        }

    }

    public function findAvailableBooks(): PDOStatement
    {
        $sql = <<<EOD
            SELECT b.*, u.pseudo
            FROM books b
            INNER JOIN users u ON u.id = b.user_id
            WHERE b.statut = 1
            ORDER BY b.id DESC;
            EOD;
        return $this->db->query($sql);
    }

    public function findLastBooks() : PDOStatement
    {
        return $this->findBooks(4);
    }

    public function findBookByUser(User $user) : array
    {
        $id = $user->getId();

        $sql = <<<EOD
                SELECT *
                FROM books
                Where user_id = $id
                EOD;

        return $this->db->query($sql)->fetchAll();

    }

    public function findBookById(int $id) : ?Book
    {
        $sql = <<<EOD
                SELECT * 
                FROM books
                WHERE id = $id;
                EOD;

        $result = $this->db->query($sql)->fetch();

        if ($result !== null){
            $book = new Book();
            $book->setId($result['id']);
            $book->setUserId($result['user_id']);
            $book->setTitle($result['title']);
            $book->setDescription($result['description']);
            $book->setAuthor($result['author']);
            $book->setImage($result['image']);
            $book->setStatut($result['statut']);
            return $book;
        }

        return null;
    }

    public function addBook(Book $book) : array|null
    {

        $errorMessages = $this->checkFields($book);

        if (!empty($errorMessages)) {
            return $errorMessages;
        }

        if ($book->getImage() === null){
            $book->setImage('default-book.png');
        }

        $bookSql = <<<EOD
                INSERT INTO books
                (user_id, title, description, author, image, statut)
                VALUES (:user_id, :title, :description, :author, :image, :statut)
                EOD;

        $this->db->query($bookSql, [
            'user_id' => $book->getUserId(),
            'title' => $book->getTitle(),
            'description' => $book->getDescription(),
            'author' => $book->getAuthor(),
            'image' => $book->getImage(),
            'statut' => (int)$book->getStatut()
        ]);

        return null;
    }
    public function updateBook(int $id, Book $book)
    {
        $actualBook = $this->findBookById($id);
        $book->setImage($actualBook->getImage());
        $errorMessages = $this->checkFields($book);

        if (!empty($errorMessages)) {
            return $errorMessages;
        }

        $bookSql = <<<EOD
                UPDATE books
                SET title = :title, description = :description, author = :author, image = :image, statut = :statut
                WHERE id = :id;
                EOD;

        $this->db->query($bookSql, [
            'title' => $book->getTitle(),
            'description' => $book->getDescription(),
            'author' => $book->getAuthor(),
            'image' => $book->getImage(),
            'statut' => (int)$book->getStatut(),
            'id' => $id
        ]);

        return null;

    }
    public function deleteBookById(int $idBook, int $idUser) : void
    {
        $imgSql = <<<EOD
                SELECT image
                FROM books
                WHERE id = $idBook
                AND user_id = $idUser
                EOD;

        $imagePath = $this->db->query($imgSql)->fetch();
        if ($imagePath['image'] !== 'default-book.png') {
            $deleteDir = dirname(__DIR__, 2) . '/books_img/';
            unlink($deleteDir . $imagePath['image']);
        }

        $findBookSQL = <<<EOD
                        DELETE
                        FROM books
                        WHERE id = $idBook
                        AND user_id = $idUser
                        EOD;

        $this->db->query($findBookSQL);
    }



    private function checkFields(Book $book): array
    {
        $errorMessages = [];

        if (isset($_FILES['picture']) && $_FILES['picture']['error'] !== UPLOAD_ERR_NO_FILE){

            $errors = Utils::checkImage($_FILES);

            if ($errors === null) {

                if ($_FILES['picture']['type'] === 'image/jpeg' || $_FILES['picture']['type'] === 'image/jpg') {
                    $type = '.jpeg';
                } else {
                    $type = '.png';
                }

                $name = uniqid('', false);

                //On sauvegarde l'image dans notre dossier d'image
                $uploadDir = dirname(__DIR__, 2) . '/books_img/';
                $newName = $name . $type;
                move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir . $newName);

                $book->setImage($newName);

            }

        }

        unset($_FILES);
        //Check longueur du titre et de l'auteur
        if (mb_strlen($book->getTitle()) > 250 || mb_strlen($book->getAuthor()) > 250) {
            $errorMessages[] = 'Le titre et l\' auteur ne peuvent pas dépasser les 250 caractères.';
        }

        return $errorMessages;

    }

    public function findBooksByKeyword($keyword) : array
    {
        $sql = <<<EOD
                SELECT b.* , u.pseudo
                FROM books b
                INNER JOIN users u ON u.id = b.user_id
                WHERE title LIKE :keyword
                EOD;

        return $this->db->query($sql, [':keyword' => "%$keyword%"])->fetchAll();
    }

}