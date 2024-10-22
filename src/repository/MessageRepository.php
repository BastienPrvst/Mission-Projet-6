<?php

class MessageRepository extends AbstractEntityManager
{
    public function sendMessage(string $message, int $senderId, int $receiverId) : void
    {
        $sql = <<<EOD
                INSERT INTO
                messages (send_by, received_by, text, date, seen)
                VALUES (:senderId, :receiverId, :message, NOW(), 0)
                EOD;

        $this->db->query($sql,[
            'senderId' => $senderId,
            'receiverId' => $receiverId,
            'message' => $message
        ]);

    }

    public function retrieveAllDistinctMessages(int $id) : array
    {

//        https://stackoverflow.com/questions/2129693/restrict-results-to-top-n-rows-per-group
//        https://sql.sh/cours/case

        $sql = <<<EOD
                SELECT send_by, received_by, text, date, seen, users.pseudo, other
                FROM (
                    SELECT send_by, received_by, text, date, seen,
                            CASE 
                                WHEN send_by = :id THEN received_by
                                WHEN received_by = :id THEN send_by
                            END AS other,
                            ROW_NUMBER() OVER (PARTITION BY
                                CASE
                                   WHEN send_by = :id THEN received_by
                                   WHEN received_by = :id THEN send_by
                                END ORDER BY date DESC) AS rn
                    FROM messages
                    WHERE :id IN (received_by, send_by)
                ) AS subquery
                INNER JOIN users ON subquery.other = users.id
                WHERE rn = 1
                ORDER BY date DESC
                EOD;

        return $this->db->query($sql,['id' => $id])->fetchAll();


    }

    public function retrieveConversation(int $id, int $userId) : array
    {
        $sql = <<<EOD
                SELECT *
                FROM messages
                WHERE :id IN (send_by, received_by)
                AND :userId IN (received_by, send_by)
                EOD;

        $messages = $this->db->query($sql,['id' => $id,'userId' => $userId])->fetchAll();

        $conversation = [];
        $idToUpdate = [];

        foreach ($messages as $message) {
            $msg = new Messages();
            $msg->setId($message['id']);
            $msg->setText($message['text']);
            $msg->setDate(new \DateTime($message['date']));
            $msg->setSendBy($message['send_by']);
            $msg->setReceivedBy($message['received_by']);
            $msg->setSeen(true);
            $conversation[] = $msg;

            $idToUpdate [] = $message['id'];
        }

        $idToUpdate = implode(',',$idToUpdate);

        $sql = <<<EOD
                    UPDATE messages
                    SET seen = true
                    WHERE id in ($idToUpdate)
                    EOD;
        $this->db->query($sql);

        return $conversation;

    }
}