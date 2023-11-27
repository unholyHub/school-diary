<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/views/SubjectScheduleView.php';
require_once './app/views/SubjectView.php';

require_once './app/controllers/SubjectScheduleController.php';
require_once './app/controllers/SubjectController.php';

use App\Constants\AccessLevel;
use App\Controllers\SubjectController;
use App\Controllers\SubjectScheduleController;
use App\Models\SubjectScheduleModel;
use App\Views\SubjectScheduleView;
use App\Views\SubjectView;

$subjectScheduleControler = new SubjectScheduleController($db);
$subjectControler = new SubjectController($db);

$subjectView = new SubjectView();
$subjectScheduleView = new SubjectScheduleView();

$user_id = $loggedUser->getId();
// $subject_id = $_GET['subject_id'];
$url = "index.php?p=schedule-add";
// $url .= "&subject_id=" . $subject_id;
// $url .= "&user_id=" . $user_id;

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $subjectScheduleControler->deleteSubjectSchedule($id);
    session_write_close();
    header("Location: index.php?p=schedule-management");
    exit();
}

// $schedules = $subjectScheduleControler->getAllSubjectSchedule($user_id, $subject_id);
// $currentSubject = $subjectControler->get($subject_id);
$schedules = array();

$schedules = $subjectScheduleControler->getAllSubjectSchedule($user_id);

// $subjectView->rednerTitle($currentSubject);
$subjectScheduleView->renderAddButton($url);
$subjectScheduleView->renderWeekSchedule($schedules);
// $subjectScheduleView->renderSubjectSchedules($schedules);
//$subjectScheduleView->renderWeekSchedule($schedules);
