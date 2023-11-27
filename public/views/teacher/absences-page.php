<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/UserController.php';
require_once './app/controllers/AbsenceController.php';
require_once './app/controllers/SubjectController.php';

require_once './app/views/UserView.php';
require_once './app/views/AbsenceView.php';
require_once './app/views/SubjectView.php';

use App\Constants\AccessLevel;
use App\Constants\GradeTerm;
use App\Constants\GradeType;

use App\Controllers\AbsenceController;
use App\Controllers\SubjectController;

use App\Models\AbsenceModel;
use App\Models\GradeModel;

use App\Views\AbsenceView;
use App\Views\SubjectView;
use App\Views\UserView;

$userController = new UserController($db);
$userView = new UserView();

$absencesController = new AbsenceController($db);
$absenceView = new AbsenceView();
$absence = new AbsenceModel();

$subjectController = new SubjectController($db);
$subjectView = new SubjectView();

$teacher_id = $loggedUser->getId();
$student_id = $_GET['student_id'] ?? -1;
$class_id = $_GET['class_id'] ?? -1;
$absence_id = $_GET['absence_id'] ?? -1;

$absence = $absencesController->getAbsencesByAbsenceId($absence_id);

if (isset($_POST['user_id'])) {
    // Get the form data
    $absence_id = $_POST['absence_id'] ?? null;

    $user_id = $_POST['user_id'];
    $class_id = intval($_POST['class_id']);
    $subject_id = $_POST['subject_id'];
    $is_full = $_POST['is_full'];
    $created_on = $_POST['created_on'];

    // Create an instance of AbsenceModel with the submitted data
    $absence = new AbsenceModel();
    $absence->setUserId($user_id);
    $absence->setClassId($class_id);
    $absence->setSubjectId($subject_id);
    $absence->setIsFull($is_full);
    $absence->setCreatedOn($created_on);

    if ($absence_id == null) {
        echo "create";
        $absencesController->createAbsence($absence);
    } else {
        echo "edit";
        $absence->setId($absence_id);
        $absencesController->updateAbsence($absence);
    }

    session_write_close();
    $url = "index.php?p=absences-management&class_id=" . $class_id .  "&student_id=" . $user_id;
    header("Location: " . $url);
    exit();
}

$selectedUser = $userController->getUserById($student_id);
if ($absence->getId() == null) {
    $absence->setUserId($selectedUser->getId());
    $absence->setClassId($class_id);
}

$selectedUserSubjects = array();
if ($loggedUser->getRole() == AccessLevel::TEACHER) {
    $selectedUserSubjects = $subjectController->getClassesForStudentId($selectedUser->getId(), $teacher_id);
} else {
    $selectedUserSubjects = $subjectController->getClassesForStudentIdWithGrades($selectedUser->getId());
}
$absenceView->renderAddForm($absence, $selectedUserSubjects);
