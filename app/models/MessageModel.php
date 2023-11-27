<?php

namespace App\Models;

class MessageModel
{
    private $id;
    private $fromUserId;
    private $toUserId;
    private $message;
    private $sentOn;

    private $fromFullName;
    private $toFullName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFromUserId(): ?int
    {
        return $this->fromUserId;
    }

    public function setFromUserId(int $fromUserId): void
    {
        $this->fromUserId = $fromUserId;
    }

    public function getToUserId(): ?int
    {
        return $this->toUserId;
    }

    public function setToUserId(int $toUserId): void
    {
        $this->toUserId = $toUserId;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getSentOn(): ?string
    {
        return $this->sentOn;
    }

    public function setSentOn(string $sentOn): void
    {
        $this->sentOn = $sentOn;
    }

    public function getFromFullName(): ?string
    {
        return $this->fromFullName;
    }

    public function setFromFullName(?string $fromFullName): void
    {
        $this->fromFullName = $fromFullName;
    }

    public function getToFullName(): ?string
    {
        return $this->toFullName;
    }

    public function setToFullName(?string $toFullName): void
    {
        $this->toFullName = $toFullName;
    }
}
