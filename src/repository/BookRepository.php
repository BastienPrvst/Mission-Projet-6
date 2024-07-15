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

}