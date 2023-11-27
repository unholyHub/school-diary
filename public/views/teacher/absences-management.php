<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/UserController.php';
require_once './app/controllers/SubjectController.php';
require_once './app/controllers/ClassController.php';
require_once './app/controllers/AbsenceController.php';

require_once './app/views/UserView.php';
require_once './app/views/SubjectView.php';
require_once './app/views/AbsenceView.php';

use App\Constants\AccessLevel;
use App\Controllers\AbsenceController;
use App\Controllers\SubjectController;
use App\Controllers\ClassController;

use App\Models\AbsenceModel;

use App\Views\AbsenceView;
use App\Views\SubjectView;
use App\Views\UserView;

$student_id = $_GET['student_id'] ?? -1;
$class_id = $_GET['class_id'] ?? -1;

$teacher_id = $loggedUser->getId();

$classController = new ClassController($db);

$userController = new UserController($db);
$userView = new UserView();

$subjectController = new SubjectController($db);
$subjectView = new SubjectView();

$absencesController = new AbsenceController($db);
$absenceView = new AbsenceView();

if ($loggedUser->getRole() == AccessLevel::STUDENT) {
    $student_id = $loggedUser->getId();
}

$studentClass = $classController->getClassByUserId($student_id);
$class_id = $studentClass->getId();

$absence = new AbsenceModel();
$absence->setUserId($student_id);
$absence->setClassId($class_id);

$selectedUser = $userController->getUserById($student_id);
$selectedUser->setClass($classController->getClassByUserId($student_id)->getFullClassName());

$userView->renderBack();
$userView->renderStudentName($selectedUser);

$absencesCount = $absencesController->getAllAbsencesForUser($selectedUser->getId());

if ($loggedUser->getRole() != AccessLevel::STUDENT) {
    $absenceView->renderAddButton($absence);
}

$subjectsForStudent = $subjectController->getClassesForStudentIdWithGrades($student_id);

foreach ($subjectsForStudent as $s) {
    $subject_id = $s->getId();
    $subjectView->rednerTitle($s);
    $absence->setSubjectId($subject_id);
    $absencesForSubject = $subjectAbsenses = $absencesController->getAbsensesByUserIdAndSubjectId($absence);
    $absenceView->renderSubjectAbsenses($absencesForSubject);
}

$absenceView->renderAllAbsences($absencesCount);
