<?php

namespace App\Models;

class SubjectTopicModel
{
    private $id;
    private $subjectId;
    private $name;
    private $week;
    private $subjectName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getSubjectId(): ?int
    {
        return $this->subjectId;
    }

    public function setSubjectId(?int $subjectId): void
    {
        $this->subjectId = $subjectId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getSubjectName(): ?string
    {
        return $this->subjectName;
    }

    public function setSubjectName(?string $subjectName): void
    {
        $this->subjectName = $subjectName;
    }

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(?string $week): void
    {
        $this->week = $week;
    }
}
