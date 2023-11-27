<?php

namespace App\Controllers;

require_once './app/models/GradeModel.php';
require_once './app/models/repositories/GradeRepository.php';

use App\Constants\GradeTerm;
use App\Models\GradeModel;
use App\Repositories\GradeRepository;
use Config\Database;

class GradeController
{
    private $gradeRepository;

    public function __construct(Database $db)
    {
        $this->gradeRepository = new GradeRepository($db);
    }

    public function createGrade(GradeModel $gradeModel)
    {
        $id = $this->checkIfGradeExists($gradeModel);
        if ($id != -1) {
            $gradeModel->setId($id);
            return $this->updateGrade($gradeModel);
        }

        return $this->gradeRepository->createGrade($gradeModel);
    }

    public function getGradeById($id)
    {
        return $this->gradeRepository->getGradeById($id);
    }

    public function updateGrade($gradeModel)
    {
        return $this->gradeRepository->updateGrade($gradeModel);
    }

    public function checkIfGradeExists(GradeModel $grade)
    {
        return $this->gradeRepository->checkIfGradeExists($grade);
    }

    public function getGradesForSubject(GradeModel $gradeModel)
    {
        return $this->gradeRepository->getGradesForSubject($gradeModel);
    }
}
