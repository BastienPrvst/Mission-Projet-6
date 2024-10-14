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
}