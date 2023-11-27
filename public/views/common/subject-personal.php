<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/SubjectController.php';
require_once './app/views/SubjectView.php';

use App\Constants\AccessLevel;
use App\Controllers\SubjectController;
use App\Views\SubjectView;

$subjectControler = new SubjectController($db);
$subjectView = new SubjectView();

if ($loggedUser->getRole() == AccessLevel::TEACHER) {
    $teacher_id = $loggedUser->getId();
    $subjects = $subjectControler->getAllLinked($teacher_id);
    $subjectView->renderAddSubjectWithSection();
    $subjectView->renderAllSubjectsTableForTeacher($subjects, $teacher_id);
}

if ($loggedUser->getRole() == AccessLevel::STUDENT) {
    $student_id = $loggedUser->getId();
    $subjects = $subjectControler->getClassesForStudentIdWithGrades($student_id);
    $subjectView->renderAllSubjectsTableForStudent($subjects);
}
