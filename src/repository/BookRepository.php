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

            var_dump($exception->getMessage());
            exit(0);
        }


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

    public function addBook(Book $book) : array|null
    {
        if ($book->getImage() !== null) {
            $_FILES['picture']['type'] = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['picture']['tmp_name']);

            if ($_FILES['picture']['type'] !== 'image/jpeg' && ($_FILES['picture']['type'] !== ('image/png')) && $_FILES['picture']['type'] !== 'image/jpg') {

                $errorMessages[] = 'Le type de fichier n\'est pas valide';
                return $errorMessages;
            }

            if (isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                $error = $_FILES['file']['error'];
                $errorMessages = [];

                if ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE) {
                }
                {
                    $errorMessages[] = "Le fichier dépasse la taille maximale autorisée.";
                }

                if ($error === UPLOAD_ERR_PARTIAL) {
                    $errorMessages[] = "Le fichier n'a été que partiellement téléchargé.";
                }

                if ($error === UPLOAD_ERR_NO_FILE) {
                    $errorMessages[] = "Aucun fichier n'a été téléchargé.";
                }

                if ($error === UPLOAD_ERR_NO_TMP_DIR) {
                    $errorMessages[] = "Le dossier temporaire est manquant.";
                }

                if ($error === UPLOAD_ERR_CANT_WRITE) {
                    $errorMessages[] = "Échec de l'écriture du fichier sur le disque.";
                }

                if ($error === UPLOAD_ERR_EXTENSION) {
                    $errorMessages[] = "Une extension PHP a arrêté le téléchargement du fichier.";
                }
            }

            if ($_FILES['picture']['type'] === 'image/jpeg' || $_FILES['picture']['type'] === 'image/jpg') {
                $type = '.jpeg';
            } else {
                $type = '.png';
            }

            function generateRandomString($length = 10)
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $shuffled = str_shuffle($characters);
                return substr($shuffled, 0, $length);
            }

            $name = generateRandomString(10);

            //On sauvegarde l'image dans notre dossier d'image
            $uploadDir = dirname(__DIR__, 2) . '/books_img/';
            $newName = $name . $type;
            move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir . $newName);

            $book->setImage($newName);

            unset($_FILES);


        } else {
            $book->setImage('default-book.png');
        }

        //Check longueur du titre et de l'auteur
        if (mb_strlen($book->getTitle() > 250 || mb_strlen($book->getAuthor() > 250))){
            $errorMessages[] = 'Le titre et l\' auteur ne peuvent pas dépasser les 250 caractères?';
        }

        if (!empty($errorMessages)) {
            return $errorMessages;
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
            'statut' => $book->getStatut()
        ]);

        return null;
    }

}