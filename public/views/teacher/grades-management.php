<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/UserController.php';
require_once './app/controllers/SubjectController.php';
require_once './app/controllers/GradeController.php';
require_once './app/controllers/ClassController.php';

require_once './app/views/UserView.php';
require_once './app/views/GradeView.php';
require_once './app/views/SubjectView.php';

use App\Constants\AccessLevel;
use App\Controllers\GradeController;
use App\Controllers\SubjectController;
use App\Controllers\ClassController;

use App\Models\GradeModel;

use App\Views\GradeView;
use App\Views\SubjectView;
use App\Views\UserView;

$classController = new ClassController($db);

$userController = new UserController($db);
$userView = new UserView();

$gradeController = new GradeController($db);
$gradeView = new GradeView();

$subjectController = new SubjectController($db);
$subjectView = new SubjectView();

$student_id = $_GET['student_id'] ?? -1;
$class_id = $_GET['class_id'] ?? -1;

if ($loggedUser->getRole() == AccessLevel::STUDENT) {
    $student_id = $loggedUser->getId();
    $studentClass = $classController->getClassByUserId($student_id);
    $class_id = $studentClass->getId();
}

$selectedUser = $userController->getUserById($student_id);
$selectedUser->setClass($classController->getClassByUserId($student_id)->getFullClassName());

$userView->renderBack();
$userView->renderStudentName($selectedUser);

if ($loggedUser->getRole() != AccessLevel::STUDENT) {
    $gradeView->renderAddGradeButton($class_id, $selectedUser->getId());
}

$subjects =  $subjectController->getClassesForStudentIdWithGrades($student_id);

foreach ($subjects as $s) {
    $subjectView->rednerTitle($s);

    $gradeForSubject = new GradeModel();
    $gradeForSubject->setUserId($student_id);
    $gradeForSubject->setSubjectId($s->getId());

    // TODO get all grades
    $grades = $gradeController->getGradesForSubject($gradeForSubject);
    $fullGradesList = GradeModel::generateOutputArray($grades);
    if ($loggedUser->getRole() != AccessLevel::STUDENT) {
        $gradeView->renderSubjectGradesTable($fullGradesList, $class_id);
    } else {
        $gradeView->renderSubjectGradesTableForStudent($fullGradesList);
    }
}
