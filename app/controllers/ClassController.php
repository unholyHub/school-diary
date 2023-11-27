<?php

namespace App\Controllers;

require_once './app/models/ClassModel.php';

use App\Models\ClassModel;

require_once './app/models/repositories/ClassRepository.php';

use App\Repositories\ClassRepository;

require_once './app/views/ClassView.php';

use App\Views\ClassView;

use Config\Database;

class ClassController
{
    private $classRepository;

    public function __construct(Database $db)
    {
        $this->classRepository = new ClassRepository($db);
    }

    public function search($searchTerm)
    {
        return $this->classRepository->search($searchTerm);
    }

    public function get($id)
    {
        return $this->classRepository->get($id);
    }

    public function getAll()
    {
        return $this->classRepository->getAll();
    }

    public function create(ClassModel $class)
    {
        return $this->classRepository->create($class);
    }

    public function modify(ClassModel $class)
    {
        return $this->classRepository->modify($class);
    }

    public function delete($id)
    {
        return $this->classRepository->delete($id);
    }

    public function existsById(ClassModel $class)
    {
        return $this->classRepository->checkClassExists($class);
    }

    public function existsByClassName(ClassModel $class)
    {
        return $this->classRepository->checkClassExistsByName($class);
    }

    public function addUserToClass($class_id, $user_id)
    {
        if ($this->classRepository->updateStudentClass($class_id, $user_id)) {
            return true;
        }

        return $this->classRepository->addUserToClass($class_id, $user_id);
    }

    public function getClassByUserId($user_id)
    {
        return $this->classRepository->getClassByUserId($user_id);
    }

    public function getClassesBySubjectId($subject_id)
    {
        return $this->classRepository->getClassesBySubjectId($subject_id);
    }

    public function getClassesForTeacherSubjects($user_id)
    {
        return $this->classRepository->getClassesForTeacherSubjects($user_id);
    }

    public function getAllStudents($class_id)
    {
        return $this->classRepository->getAllStudents($class_id);
    }

    public function getAllForStudentModification($student_id)
    {
        return $this->classRepository->getAllForStudentModification($student_id);
    }
}
