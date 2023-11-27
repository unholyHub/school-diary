<?php

namespace App\Controllers;

require_once './app/models/repositories/SubjectScheduleRepository.php';
require_once './app/models/SubjectScheduleModel.php';

use App\Repositories\SubjectScheduleRepository;
use App\Models\SubjectScheduleModel;
use Config\Database;

class SubjectScheduleController
{
    private $subjectScheduleRepository;

    public function __construct(Database $db)
    {
        $this->subjectScheduleRepository = new SubjectScheduleRepository($db);
    }

    public function getById(int $id)
    {
        return $this->subjectScheduleRepository->getById($id);
    }

    public function getAllSubjectSchedule($user_id)
    {
        return $this->subjectScheduleRepository->getAllForUser($user_id);
    }

    public function createSubjectSchedule(SubjectScheduleModel $subjectScheduleModel)
    {
        return $this->subjectScheduleRepository->createSubjectSchedule($subjectScheduleModel);
    }

    public function updateSubjectSchedule(SubjectScheduleModel $subjectSchedule)
    {
        return $this->subjectScheduleRepository->updateSubjectSchedule($subjectSchedule);
    }

    public function deleteSubjectSchedule(int $id)
    {
        return $this->subjectScheduleRepository->deleteSubjectSchedule($id);
    }

    public function isTimeSlotFree(SubjectScheduleModel $subjectSchedule)
    {
        return $this->subjectScheduleRepository->isTimeSlotFree($subjectSchedule);
    }

    public function checkIfClassIdIsFree(SubjectScheduleModel $schedule)
    {
        return $this->subjectScheduleRepository->checkIfClassIdIsFree($schedule);
    }

    public function checkIfUserIdIsFree(SubjectScheduleModel $schedule)
    {
        return $this->subjectScheduleRepository->checkIfUserIdIsFree($schedule);
    }
}
