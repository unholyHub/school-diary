<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/SubjectController.php';
use App\Controllers\SubjectController;

require_once './app/views/SubjectView.php';
use App\Views\SubjectView;

$subjectControler = new SubjectController($db);
$subjectView = new SubjectView();

$subjects = array();

if (isset($_POST['searchterm'])) {
    $subjects = $subjectControler->search($_POST['searchterm']);
} else {
    $subjects = $subjectControler->getAll();
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $subjectControler->delete($id);
    header("Location: index.php?p=subject-management");
}

$subjectView->renderSearchBox("index.php?p=subject-management");

if (count($subjects) > 0) {
    $subjectView->renderAllSubjectsTable($subjects);
} else {
    echo "<div>Няма добавени предмети</div>";
}
