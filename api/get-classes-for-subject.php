<?php
header('Content-Type: application/json;charset=UTF-8');

use App\Controllers\ClassController;
use App\Models\ClassModel;

require_once './app/controllers/ClassController.php';

$classController = new ClassController($db);
$jsonData = file_get_contents('php://input');
$requestData = json_decode($jsonData, true);

$arr = array();
$subject_id = intval($requestData['subject_id']);
$classes = $classController->getClassesBySubjectId($subject_id);

foreach ($classes as $c) {
    $classData = array(
        'id' => $c->getId(),
        'class' => $c->getFullClassName()
    );
    $arr[] = $classData;
}

echo json_encode($arr);
