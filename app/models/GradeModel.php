<?php

namespace App\Models;

use App\Constants\GradeTerm;
use App\Constants\GradeType;

class GradeModel
{
    private $id;

    private $userId;
    private $subjectId;

    private $grade;

    private $finalGrade;

    private $term;

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

    public function setSubjectId(?int $subjectId): void
    {
        $this->subjectId = $subjectId;
    }

    public function getGrade(): ?int
    {
        return $this->grade;
    }

    public function setGrade(?int $grade): void
    {
        $this->grade = $grade;
    }

    public function getFinalGrade(): ?int
    {
        return $this->finalGrade;
    }

    public function setFinalGrade(?int $finalGrade): void
    {
        $this->finalGrade = $finalGrade;
    }

    public function getTerm(): ?int
    {
        return $this->term;
    }

    public function setTerm(?int $term): void
    {
        $this->term = $term;
    }

    public static function generateOutputArray(array $grades): array
    {
        $outputArray = array(
            GradeTerm::FIRST => array(
                GradeType::CURRENT => array(),
                GradeType::FINAL => new GradeModel()
            ),
            GradeTerm::SECOND => array(
                GradeType::CURRENT => array(),
                GradeType::FINAL => new GradeModel()
            ),
            GradeTerm::FINAL => new GradeModel()
        );

        // foreach ($grades as $g) {
        //     $term = $g->getTerm();
        //     if ($term == GradeTerm::FINAL) {
        //         $outputArray[GradeTerm::FINAL] = $g;
        //     } else {
        //         $gradeType = $g->getFinalGrade() === null ? "current" : "final";
        //         $outputArray[$term][$gradeType] = $g;
        //     }
        // }


        foreach ($grades as $g) {
            if ($g->getTerm() == GradeTerm::FINAL) {
                $outputArray[$g->getTerm()] = $g;
                continue;
            }

            $term = $g->getTerm();

            if ($g->getFinalGrade() == null) {
                $outputArray[$term][GradeType::CURRENT][] = $g;
            } else {
                $outputArray[$term][GradeType::FINAL] = $g;
            }
        }

        return $outputArray;
    }
}
