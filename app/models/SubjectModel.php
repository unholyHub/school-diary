<?php

namespace App\Models;

class SubjectModel
{
    private $id;
    private $name;
    private $minStartingGrade;
    private $maxEndingGrade; // New property for max ending grade
    private $isMain;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getMinStartingGrade()
    {
        return $this->minStartingGrade;
    }

    public function setMinStartingGrade($minStartingGrade)
    {
        $this->minStartingGrade = $minStartingGrade;
    }

    public function getMaxEndingGrade()
    {
        return $this->maxEndingGrade;
    }

    public function setMaxEndingGrade($maxEndingGrade)
    {
        $this->maxEndingGrade = $maxEndingGrade;
    }

    public function getIsMain() : ?int
    {
        return $this->isMain;
    }

    public function setIsMain($isItMain)
    {
        $this->isMain = $isItMain;
    }
}
