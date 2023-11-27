<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/ClassController.php';
require_once './app/views/ClassView.php';

use App\Controllers\ClassController;
use App\Views\ClassView;

$classController = new ClassController($db);
$classView = new ClassView();

$user_id = $loggedUser->getId();

$classes = $classController->getClassesForTeacherSubjects($user_id);

$classView->renderClassesForTeacher($classes);