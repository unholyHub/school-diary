<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/SubjectTopicController.php';
require_once './app/controllers/SubjectController.php';

require_once './app/views/SubjectTopicView.php';
require_once './app/views/SubjectView.php';

use App\Controllers\SubjectController;
use App\Controllers\SubjectTopicController;
use App\Models\SubjectTopicModel;
use App\Views\SubjectTopicView;
use App\Views\SubjectView;

$subjectTopicController = new SubjectTopicController($db);
$subjectController = new SubjectController($db);

$subjectTopicView = new SubjectTopicView();
$subjectView = new SubjectView();

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : -1;
$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : -1;

if (isset($_GET['delete_id'])) {
    $subjectTopicController->deleteSubjectTopic($_GET['delete_id']);
    $subject_id = $_GET['subject_id'];
    session_write_close();
    header("Location: index.php?p=subject-topic-management&subject_id=" . $subject_id);
    exit();
}

if (isset($_GET['topic_id'])) {
    $topic_id = $_GET['topic_id'];
    $selectedTopic = $subjectTopicController->getSubjectTopicById($topic_id);
    $subject_id = $selectedTopic->getSubjectId();
    $subjectTopicView->renderEditForm($selectedTopic);
} else {
    $subjectTopicView->renderAddForm($subject_id);
}

$selectedSubject = $subjectController->get($subject_id);
$subjectView->rednerTitle($selectedSubject);

if (isset($_POST['subject_id']) || isset($_POST['topic_id'])) {
    $subject_id = $_POST['subject_id'] ?? -1;
    $topic_id = $_POST['topic_id'] ?? -1;
    $name = $_POST['topic_name'];
    $week = $_POST['topic_week'];

    $subjectTopic = new SubjectTopicModel();
    $subjectTopic->setSubjectId($subject_id);
    $subjectTopic->setName($name);
    $subjectTopic->setWeek($week);

    if ($topic_id == -1) {
        // create 
        $subjectTopicController->createSubjectTopic($subjectTopic);
    }

    if ($subject_id == -1) {
        //edit
        $subjectTopic->setId($topic_id);
        $selectedSubject = $subjectTopicController->getSubjectTopicById($topic_id);
        $subject_id = $selectedSubject->getSubjectId();
        $subjectTopicController->updateSubjectTopic($subjectTopic);
    }

    header("Location: index.php?p=subject-topic-management&subject_id=" . $subject_id);
    exit();
}

$topics = $subjectTopicController->getAllTopicsBySubjectId($subject_id);
$subjectTopicView->renderTableTopics($topics);;
