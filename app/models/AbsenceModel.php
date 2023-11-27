<?php

namespace App\Models;

class AbsenceModel
{
    private $id;

    private $userId;
    private $subjectId;

    private $isFull;

    private $createdOn;

    private $classId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    public function getSubjectId(): ?int
    {
        return $this->subjectId;
    }

    public function setClassId(?int $classId): void
    {
        $this->classId = $classId;
    }

    public function getClassId(): ?int
    {
        return $this->classId;
    }

    public function setSubjectId(?int $subjectId): void
    {
        $this->subjectId = $subjectId;
    }

    public function getIsFull(): ?int
    {
        return $this->isFull ?? -1;
    }

    public function setIsFull(?int $isFull): void
    {
        $this->isFull = $isFull;
    }

    public function getCreatedOn(): ?string
    {
        return $this->createdOn;
    }

    public function setCreatedOn(?string $createdOn): void
    {
        $this->createdOn = $createdOn;
    }
}
