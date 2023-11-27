<?php

require_once './app/controllers/UserController.php';

require_once './app/controllers/SubjectController.php';

use App\Controllers\SubjectController;

require_once './app/views/SubjectView.php';

use App\Views\SubjectView;

require_once './app/views/UserView.php';

use App\Views\UserView;

$userController = new UserController($db);
$subjectController = new SubjectController($db);

$subjectView = new SubjectView();
$userView = new UserView();

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : "";

if (empty($user_id)) {
    $user_id = $loggedUser->getId();
}

$url = "index.php?p=user-subjects&user_id=" . $user_id;

if (isset($_POST['subject_id'])) {
    $subject_id = $_POST['subject_id'];
    $user_id = $_POST['user_id'];
    $subjectController->removeTeacherFromSubject($user_id, $subject_id);
    $url = "index.php?p=user-subjects&user_id=" . $user_id;
    session_write_close();
    header("Location: " . $url);
    exit();
}

if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    $subjectController->addTeacherToSubject($user_id, $subject_id);
}

$teacher = $userController->getUserById($user_id);
$teacher_subjects = $userController->getAllSubjetsByUserId($user_id);
$userView->renderTeacherSubjects($url, $teacher, $teacher_subjects);

$subjects = array();

if (isset($_POST['searchterm'])) {
    $subjects = $subjectController->searchNotLinked($user_id, $_POST['searchterm']);
} else {
    $subjects = $subjectController->getAllNotLinked($user_id);
}

$subjectView->renderSearchBox($url, false);

if (count($subjects) > 0) {
    $subjectView->renderAllSubjectsTable($subjects, true);
} else {
    echo "<div>Няма добавени предмети</div>";
}
