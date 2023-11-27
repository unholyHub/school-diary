<?php

namespace App\Models;

class ClassModel
{
    private $id;

    private $classNumber;

    private $classChar;

    private $userIds;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getClassNumber(): ?int
    {
        return $this->classNumber;
    }

    public function setClassNumber($classNumber): void
    {
        $this->classNumber = $classNumber;
    }

    public function getClassChar(): ?string
    {
        return $this->classChar;
    }

    public function setClassChar($classChar): void
    {
        $this->classChar = $classChar;
    }

    public function getUserIds()
    {
        return $this->userIds;
    }

    public function getFullClassName() {
        return $this->classNumber . $this->classChar;
    }

    public function setUserIds(array $userIds)
    {
        $this->userIds = $userIds;
    }

    public function addUserId(int $userId): void
    {
        if (!in_array($userId, $this->userIds)) {
            $this->userIds[] = $userId;
        }
    }
}
