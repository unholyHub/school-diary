<?php

namespace App\Controllers;

require_once './app/models/repositories/MessagesRepository.php';
require_once './app/models/MessageModel.php';

use App\Models\MessageModel;
use App\Repositories\MessagesRepository;
use Config\Database;

class MessagesController
{
    private $messagesRepository;

    public function __construct(Database $db)
    {
        $this->messagesRepository = new MessagesRepository($db);
    }

    public function sendMessage(MessageModel $message)
    {
        return $this->messagesRepository->addMessage($message);
    }

    public function getMessagesByUserId(int $userId)
    {
        return $this->messagesRepository->getMessageById($userId);
    }

    public function updateMessage(MessageModel $message)
    {
        return $this->messagesRepository->updateMessage($message);
    }

    public function getMessageById(int $messageId)
    {
        return $this->messagesRepository->getMessageById($messageId);
    }

    public function deleteMessage(int $messageId)
    {
        return $this->messagesRepository->deleteMessage($messageId);
    }

    public function getAllMessagesToUserFromMod($student_id)
    {
        return $this->messagesRepository->getAllMessagesToUserFromMod($student_id);
    }
}
