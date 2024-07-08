<?php


class BookRepository extends AbstractEntityManager
{
    public function findBooks(?int $limit = null) : PDOStatement
    {

        if ($limit !== null) {
            $sql = <<<EOD
            SELECT * 
            FROM books 
            LIMIT :limit;
            EOD;
        }else{
            $sql = <<<EOD
            SELECT * 
            FROM books;
            EOD;
        }

        return $this->db->query($sql, ['limit' => $limit]);
    }

    public function findLastBooks() : array
    {
        $this->findBooks(4);
    }

}