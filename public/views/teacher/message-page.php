<?php

use App\Constants\AccessLevel;

if (!isset($loggedUser)) {
    return;
}

use App\Views\UserView;

use App\Controllers\MessagesController;
use App\Models\MessageModel;
use App\Views\MessageView;

require_once './app/controllers/UserController.php';
require_once './app/controllers/MessageController.php';

require_once './app/views/MessagesView.php';
require_once './app/views/UserView.php';

$userController = new UserController($db);
$messageController = new MessagesController($db);

$userView = new UserView();
$messageView = new MessageView();

$teacher_id = $loggedUser->getId();
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : -1;
$message_id = isset($_GET['message_id']) ? $_GET['message_id'] : -1;

if ($loggedUser->getRole() == AccessLevel::STUDENT) {
    $student_id = $loggedUser->getId();
}

$selectedUser = $userController->getUserById($student_id);

if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];
    $student_id = $_POST["user_id"];
    $newMessageContent = $_POST['message'];

    $message = new MessageModel();
    $message->setMessage($newMessageContent);
    $message->setId($message_id);

    $messageController->updateMessage($message);
    session_write_close();
    header("Location: index.php?p=message-page&student_id=" . $student_id);
    exit();
}

if (isset($_POST['user_id'])) {
    $student_id = $_POST["user_id"];
    $message = $_POST["message"];

    $newMessage = new MessageModel();
    $newMessage->setFromUserId($teacher_id);
    $newMessage->setToUserId($student_id);
    $newMessage->setMessage($message);

    $messageController->sendMessage($newMessage);
    session_write_close();
    header("Location: index.php?p=message-page&student_id=" . $student_id);
    exit();
}

$messagesToUser = $messageController->getAllMessagesToUserFromMod($student_id);

$userView->renderBack();

if ($loggedUser->getRole() == AccessLevel::STUDENT) {
    $messageView->renderMessagesToUser($messagesToUser);
}

if ($loggedUser->getRole() != AccessLevel::STUDENT) {
    if ($message_id == -1) {
        $messageView->renderMessageBox($selectedUser);
    } else {
        $messageToEdit = $messageController->getMessageById($message_id);
        $messageView->renderEditForm($messageToEdit);
    }

    $messageView->renderMessagesToUserFromMod($messagesToUser);
}
