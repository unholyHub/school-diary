<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/SubjectController.php';

use App\Controllers\SubjectController;

require_once './app/views/SubjectView.php';

use App\Views\SubjectView;
use App\Models\SubjectModel;

$subjectControler = new SubjectController($db);
$selectedSubject = new SubjectModel();

$url = "index.php?p=subject-page&";

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $selectedSubject = $subjectControler->get($id);
    $url .= "edit=" . $id;
}

if (isset($_POST["subject_name"])) {
    $url = "index.php?p=subject-management";

    $subject_id = isset($_POST["subject_id"]) ? $_POST["subject_id"] : null;

    $subjectName = $_POST["subject_name"];
    $minStartingGrade = $_POST["min_starting_grade"];
    $maxEndingGrade = $_POST["max_ending_grade"];
    $isMain = $_POST["is_main"];

    if ($maxEndingGrade < $minStartingGrade) {
        session_write_close();
        header("Location: " . $url . "&d=duplicate");
        exit();
    }

    $submittedSubject = new SubjectModel();
    $submittedSubject->setId($subject_id);
    $submittedSubject->setName($subjectName);
    $submittedSubject->setMinStartingGrade($minStartingGrade);
    $submittedSubject->setMaxEndingGrade($maxEndingGrade);
    $submittedSubject->setIsMain($isMain);

    if ($subject_id == null) {
        $subjectControler->create($submittedSubject);
    }

    if ($subject_id !== null) {
        $subjectControler->modify($submittedSubject);
    }

    header("Location: " . $url);
    exit();
}

$subjectView = new SubjectView();
$subjectView->renderSubjectForm($url, $selectedSubject);
