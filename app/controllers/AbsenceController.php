<?php

namespace App\Controllers;

require_once './app/models/repositories/AbsenceRepository.php';
require_once './app/models/AbsenceModel.php';

use App\Repositories\AbsenceRepository;
use App\Models\AbsenceModel;

use Config\Database;

class AbsenceController
{
    private $absenceRepository;

    public function __construct(Database $db)
    {
        $this->absenceRepository = new AbsenceRepository($db);
    }

    public function createAbsence(AbsenceModel $absenceModel)
    {
        return $this->absenceRepository->createAbsence($absenceModel);
    }

    public function updateAbsence(AbsenceModel $absenceModel)
    {
        return $this->absenceRepository->updateAbsenceById($absenceModel);
    }

    public function deleteAbsence($absence_id)
    {
        return $this->absenceRepository->deleteAbsenceById($absence_id);
    }

    public function getAbsencesByUserId($user_id)
    {
        return $this->absenceRepository->getAbsencesByUserId($user_id);
    }

    public function getAbsencesByAbsenceId($absence_id)
    {
        return $this->absenceRepository->getAbsencesByAbsenceId($absence_id);
    }

    public function getAbsensesByUserIdAndSubjectId(AbsenceModel $absence)
    {
        return $this->absenceRepository->getAbsencesByUserIdAndSubjectId($absence);
    }

    public function getAllAbsencesForUser(int $student_id)
    {
        return $this->absenceRepository->getAllAbsencesForUser($student_id);
    }
}
