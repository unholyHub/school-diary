<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/UserController.php';
require_once './app/controllers/GradeController.php';
require_once './app/controllers/SubjectController.php';

require_once './app/views/UserView.php';
require_once './app/views/GradeView.php';
require_once './app/views/SubjectView.php';

use App\Constants\AccessLevel;
use App\Constants\GradeTerm;
use App\Constants\GradeType;
use App\Controllers\GradeController;
use App\Controllers\SubjectController;
use App\Models\GradeModel;
use App\Views\GradeView;
use App\Views\SubjectView;
use App\Views\UserView;

$userController = new UserController($db);
$userView = new UserView();

$gradeController = new GradeController($db);
$gradeView = new GradeView();

$subjectController = new SubjectController($db);
$subjectView = new SubjectView();

$teacher_id = $loggedUser->getId();
$student_id = $_GET['student_id'] ?? -1;
$class_id = $_GET['class_id'] ?? -1;

if (isset($_POST['user_id'])) {
    $user_id = $_POST["user_id"];
    $subject_id = $_POST["subject_id"];
    $class_id = $_POST["class_id"];
    $grade_id = $_POST["grade_id"] ?? null;

    // срок на ценката - 1, 2, 3
    $grade_term = $_POST["grade_term"];

    // тип на оценката - текуща-срочна
    $grade_type = $_POST["grade_type"] ?? null;
    $grade = $_POST["grade"]; // самата оценка

    $gradeModel = new GradeModel();
    $gradeModel->setUserId($user_id);
    $gradeModel->setSubjectId($subject_id);
    $gradeModel->setTerm($grade_term);

    if ($grade_term != GradeTerm::FINAL && $grade_type == GradeType::CURRENT) {
        $gradeModel->setGrade($grade);
        $gradeModel->setFinalGrade(null);
    }

    if ($grade_term != GradeTerm::FINAL && $grade_type == GradeType::FINAL) {
        $gradeModel->setGrade(null);
        $gradeModel->setFinalGrade($grade);
    }

    if ($grade_term == GradeTerm::FINAL) {
        $gradeModel->setGrade(null);
        $gradeModel->setFinalGrade($grade);
    }

    if ($grade_id == null) {
        $gradeController->createGrade($gradeModel);
    } else {
        $gradeModel->setId($grade_id);
        $gradeController->updateGrade($gradeModel);
    }

    session_write_close();
    $url = "index.php?p=grades-management&class_id=" . $class_id .  "&student_id=" . $user_id;
    header("Location: " . $url);
    exit();
}

$selectedUser = $userController->getUserById($student_id);
$grade = new GradeModel();

if (isset($_GET['grade_id'])) {
    $grade = $gradeController->getGradeById($_GET['grade_id']);
    $selectedUser->setId($grade->getUserId());
} else {
    $grade->setUserId($selectedUser->getId());
}

if ($loggedUser->getRole() == AccessLevel::TEACHER) {
    $selectedUserSubjects = $subjectController->getClassesForStudentId($selectedUser->getId(), $teacher_id);
} else {
    $selectedUserSubjects = $subjectController->getClassesForStudentIdWithGrades($selectedUser->getId());
}

$gradeView->renderGradeForm($grade, $selectedUserSubjects);
