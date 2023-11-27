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

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : -1;
$selectedClass = $classController->get($class_id);

$students = $classController->getAllStudents($class_id);

$classView->renderTitle($selectedClass);
$classView->renderStudentsForClass($class_id, $students);