<?php

namespace App\Repositories;

use App\Helpers\DateTimeHelper;
use PDO;
use App\Models\MessageModel;
use Config\Database;

class MessagesRepository
{
    private $table_name  = "messages";

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function getAllMessages(): array
    {
        $sql = "SELECT * FROM $this->table_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $messages = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $message = new MessageModel();
            $message->setId($row['id']);
            $message->setFromUserId($row['from_user_id']);
            $message->setToUserId($row['to_user_id']);
            $message->setMessage($row['message']);
            $message->setSentOn($row['sent_on']);
            $messages[] = $message;
        }

        return $messages;
    }

    public function getMessageById(int $id): ?MessageModel
    {
        $sql = "SELECT 
                    m.*,
                    CONCAT(from_user.first_name, ' ', from_user.last_name) AS from_full_name,
                    CONCAT(to_user.first_name, ' ', to_user.last_name) AS to_full_name
                FROM 
                    $this->table_name m
                INNER JOIN users from_user ON from_user.id = m.from_user_id
                INNER JOIN users to_user ON to_user.id = m.to_user_id
                WHERE 
                    m.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return new MessageModel();
        }

        $message = new MessageModel();
        $message->setId($row['id']);
        $message->setFromUserId($row['from_user_id']);
        $message->setToUserId($row['to_user_id']);

        $message->setFromFullName($row['from_full_name']);
        $message->setToFullName($row['to_full_name']);

        $message->setMessage($row['message']);
        $message->setSentOn($row['sent_on']);

        return $message;
    }

    public function addMessage(MessageModel $message): bool
    {
        $sql = "INSERT INTO $this->table_name (from_user_id, to_user_id, message, sent_on) 
                VALUES (:from_user_id, :to_user_id, :message, :sent_on)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':from_user_id', $message->getFromUserId(), PDO::PARAM_INT);
        $stmt->bindParam(':to_user_id', $message->getToUserId(), PDO::PARAM_INT);
        $stmt->bindParam(':message', $message->getMessage(), PDO::PARAM_STR);
        $stmt->bindParam(':sent_on', DateTimeHelper::getTimeSQL(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updateMessage(MessageModel $message): bool
    {
        $sql = "UPDATE $this->table_name 
                SET message = :message
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':message', $message->getMessage(), PDO::PARAM_STR);
        $stmt->bindParam(':id', $message->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteMessage(int $id): bool
    {
        $sql = "DELETE FROM $this->table_name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getAllMessagesToUserFromMod($teacher_id): array
    {
        $sql = "        
        SELECT
            m.*,
            CONCAT(from_user.first_name, ' ', from_user.last_name) AS from_full_name,
            CONCAT(to_user.first_name, ' ', to_user.last_name) AS to_full_name
        FROM
            $this->table_name m
            INNER JOIN users from_user ON from_user.id = m.from_user_id
            INNER JOIN users to_user ON to_user.id = m.to_user_id
        WHERE
            m.to_user_id = :student_id
        ORDER BY
            m.sent_on DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':student_id', $teacher_id, PDO::PARAM_INT);
        $stmt->execute();

        $messages = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $message = new MessageModel();
            $message->setId($row['id']);
            $message->setFromUserId($row['from_user_id']);
            $message->setToUserId($row['to_user_id']);

            $message->setFromFullName($row['from_full_name']);
            $message->setToFullName($row['to_full_name']);

            $message->setMessage($row['message']);
            $message->setSentOn($row['sent_on']);

            $messages[] = $message;
        }


        return $messages;
    }
}
