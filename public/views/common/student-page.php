<?php

use App\Constants\AccessLevel;

if (!isset($loggedUser) || $loggedUser->getRole() == AccessLevel::STUDENT) {
    return;
}

require_once './app/controllers/UserController.php';
require_once './app/controllers/SubjectController.php';
require_once './app/controllers/GradeController.php';
require_once './app/controllers/ClassController.php';
require_once './app/controllers/AbsenceController.php';

require_once './app/views/UserView.php';
require_once './app/views/GradeView.php';
require_once './app/views/SubjectView.php';
require_once './app/views/AbsenceView.php';

use App\Controllers\GradeController;
use App\Controllers\SubjectController;
use App\Controllers\ClassController;
use App\Controllers\AbsenceController;

use App\Models\AbsenceModel;
use App\Models\GradeModel;

use App\Views\AbsenceView;
use App\Views\GradeView;
use App\Views\SubjectView;
use App\Views\UserView;

$absenceController = new AbsenceController($db);
$absenceView = new AbsenceView();

$classController = new ClassController($db);

$userController = new UserController($db);
$userView = new UserView();

$gradeController = new GradeController($db);
$gradeView = new GradeView();

$subjectController = new SubjectController($db);
$subjectView = new SubjectView();

$student_id = $_GET['student_id'] ?? -1;
$studentClass = $classController->getClassByUserId($student_id);
$class_id = $studentClass->getId();

$selectedStudent = $userController->getUserById($student_id);
$selectedStudent->setClass($classController->getClassByUserId($student_id)->getFullClassName());

$userView->renderBack();
$userView->renderStudentName($selectedStudent);
$subjects =  $subjectController->getClassesForStudentIdWithGrades($student_id);

$gradeForSubject = new GradeModel();
$absence = new AbsenceModel();

foreach ($subjects as $s) {
    $subjectView->rednerTitle($s);

    $gradeForSubject->setUserId($student_id);
    $gradeForSubject->setSubjectId($s->getId());

    $grades = $gradeController->getGradesForSubject($gradeForSubject);
    $fullGradesList = GradeModel::generateOutputArray($grades);
    $gradeView->renderSubjectGradesTableForStudent($fullGradesList);

    $absence->setUserId($student_id);
    $absence->setSubjectId($s->getId());
    $absencesForSubject = $absenceController->getAbsensesByUserIdAndSubjectId($absence);
    $absenceView->renderSubjectAbsenses($absencesForSubject);
}
