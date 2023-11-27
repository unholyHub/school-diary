<?php

namespace App\Controllers;

require_once './app/models/SubjectModel.php';
require_once './app/models/repositories/SubjectRepository.php';

use App\Models\Repositories\SubjectRepository;
use App\Models\SubjectModel;
use App\Views\SubjectView;
use Config\Database;

class SubjectController
{
    private $subjectRepository;

    private $subjectView;

    public function __construct(Database $db)
    {
        $this->subjectRepository = new SubjectRepository($db); // Assuming you have created the SubjectRepository class.
        //$this->subjectView = new SubjectView;
    }

    public function getAll()
    {
        return $this->subjectRepository->getAllsubjects();
    }

    public function search($searchTerm)
    {
        return $this->subjectRepository->searchSubjects($searchTerm);
    }

    public function get($id)
    {
        return $this->subjectRepository->getsubjectById($id);
    }

    public function create(SubjectModel $newSubject)
    {
        return $this->subjectRepository->create($newSubject);
    }

    public function modify(SubjectModel $modifiedSubject)
    {
        return $this->subjectRepository->update($modifiedSubject);
    }

    public function delete($id)
    {
        return $this->subjectRepository->delete($id);
    }

    public function addTeacherToSubject($user_id, $subject_id)
    {
        if ($this->subjectRepository->hasUserSubjectEntry($user_id, $subject_id)) {
            return false;
        }

        return $this->subjectRepository->addTeacherToSubject($user_id, $subject_id);
    }

    public function getAllLinked($user_id)
    {
        return $this->subjectRepository->getLinkedSubjectsByUserId($user_id);
    }

    public function searchLinked($user_id, $searchTerm)
    {
        return $this->subjectRepository->getLinkedSubjectsByUserIdAndSearchTerm($user_id, $searchTerm);
    }

    public function getAllNotLinked($user_id)
    {
        return $this->subjectRepository->getUnlinkedSubjectsByUserId($user_id);
    }

    public function searchNotLinked($user_id, $searchTerm)
    {
        return $this->subjectRepository->getUnlinkedSubjectsByUserIdAndSearchTerm($user_id, $searchTerm);
    }

    public function removeTeacherFromSubject($user_id, $searchTerm)
    {
        return $this->subjectRepository->removeTeacherFromSubject($user_id, $searchTerm);
    }

    public function getClassesForStudentId($student_id, $teacher_id)
    {
        return $this->subjectRepository->getClassesForStudentId($student_id, $teacher_id);
    }

    public function getClassesForStudentIdWithGrades($student_id)
    {
        return $this->subjectRepository->getClassesForStudentIdWithGrades($student_id);
    }
}
