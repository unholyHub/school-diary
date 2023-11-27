<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/views/SubjectScheduleView.php';
require_once './app/views/SubjectView.php';

require_once './app/controllers/SubjectScheduleController.php';
require_once './app/controllers/SubjectController.php';
require_once './app/controllers/ClassController.php';

use App\Controllers\ClassController;
use App\Controllers\SubjectController;
use App\Controllers\SubjectScheduleController;

use App\Models\SubjectScheduleModel;

use App\Views\SubjectScheduleView;
use App\Views\SubjectView;

$subjectScheduleControler = new SubjectScheduleController($db);
$subjectController = new SubjectController($db);
$classController = new ClassController($db);

$subjectScheduleView = new SubjectScheduleView();
$subjectView = new SubjectView();

$schedule_id = isset($_GET['schedule_id']) ? $_GET['schedule_id'] : -1;
$subjectSchedule = $subjectScheduleControler->getById($schedule_id);

$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : $subjectSchedule->getSubjectId();
$currentSubject = $subjectController->get($subject_id);

$user_id = $loggedUser->getId();
$url = "index.php?p=schedule-add";

if ($schedule_id != -1) {
    $url .= "&schedule_id=" . $schedule_id;
}

if (isset($_POST["class_id"])) {
    $url = "index.php?p=schedule-add";
    // Sanitize and validate the input data
    $schedule_id = isset($_POST['schedule_id']) ? $_POST['schedule_id'] : null;
    $subject_id = intval($_POST['subject_id']);
    $class_id = intval($_POST['class_id']);
    $day = intval($_POST['day']);
    $program_slot = intval($_POST['program_slot']);
    $program_time_start = $_POST['program_time_start'];
    $program_time_end = $_POST['program_time_end'];

    $schedule = new SubjectScheduleModel();
    $schedule->setUserId($user_id);
    $schedule->setSubjectId($subject_id);
    $schedule->setClassId($class_id);

    $schedule->setDay($day);
    $schedule->setProgramSlot($program_slot);
    $schedule->setProgramTimeStart($program_time_start);
    $schedule->setProgramTimeEnd($program_time_end);

    $error = false;

    if (!$subjectScheduleControler->checkIfClassIdIsFree($schedule)) {
        $error = true;
        $url .= "&error_notfree=Класът има учебен час за този ден и този времеви диапазон";
    }

    if (!$subjectScheduleControler->checkIfUserIdIsFree($schedule)) {
        $error = true;
        $url .= "&error_notfree=Имате като учител учебен час за този ден и този времеви диапазон";
    }

    if (!$error && $schedule_id == null) {
        $subjectScheduleControler->createSubjectSchedule($schedule);
        $url = "index.php?p=schedule-management";
    }

    if (!$error && $schedule_id != null) {
        $schedule->setId($schedule_id);
        $subjectScheduleControler->updateSubjectSchedule($schedule);
        $url = "index.php?p=schedule-management";
    }

    session_write_close();
    header("Location: " . $url);
    exit();
}

$subjects = $subjectController->getAllLinked($user_id);
$classes = $classController->getClassesBySubjectId($subject_id);
$subjectScheduleView->renderAddScheduleForm($url, $subjectSchedule, $subjects, $classes);
