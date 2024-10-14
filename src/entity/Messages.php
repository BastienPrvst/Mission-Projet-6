<?php

class Messages
{
    private int $id;
    private int $sendBy;
    private int $receivedBy;
    private string $text;
    private \DateTime $date;
    private bool $seen = false;

    /**
     * @return int
     */
    public function getReceivedBy(): int
    {
        return $this->receivedBy;
    }

    /**
     * @param int $receivedBy
     */
    public function setReceivedBy(int $receivedBy): void
    {
        $this->receivedBy = $receivedBy;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSendBy(): int
    {
        return $this->sendBy;
    }

    /**
     * @param int $sendBy
     */
    public function setSendBy(int $sendBy): void
    {
        $this->sendBy = $sendBy;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return bool
     */
    public function isSeen(): bool
    {
        return $this->seen;
    }

    /**
     * @param bool $seen
     */
    public function setSeen(bool $seen): void
    {
        $this->seen = $seen;
    }






}