<?php

namespace App\Repositories;

use PDO;
use App\Models\SubjectTopicModel;
use Config\Database;

class SubjectTopicRepository
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function create(SubjectTopicModel $subjectTopic): bool
    {
        $sql = "INSERT INTO subject_topics (subject_id, name, week) VALUES (:subject_id, :name, :week)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':subject_id', $subjectTopic->getSubjectId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $subjectTopic->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':week', $subjectTopic->getWeek(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getById(int $id): ?SubjectTopicModel
    {
        $sql = "SELECT 
                    t.*, 
                    s.name AS subject_name 
                FROM
                    subject_topics t
                JOIN 
                    subjects s 
                ON 
                    t.subject_id = s.id
                WHERE
                     t.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return new SubjectTopicModel();
        }

        $subjectTopic = new SubjectTopicModel();
        $subjectTopic->setId($row['id']);
        $subjectTopic->setSubjectId($row['subject_id']);
        $subjectTopic->setName($row['name']);
        $subjectTopic->setSubjectName($row['subject_name']);
        $subjectTopic->setWeek($row['week']);

        return $subjectTopic;
    }

    public function update(SubjectTopicModel $subjectTopic): bool
    {
        $sql = "UPDATE subject_topics SET name = :name, week = :week WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $subjectTopic->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':week', $subjectTopic->getWeek(), PDO::PARAM_INT);
        $stmt->bindValue(':id', $subjectTopic->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM subject_topics WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getAllTopicsBySubjectId(int $subject_id): array
    {
        $sql = "SELECT t.*, s.name AS subject_name 
                FROM subject_topics t
                JOIN subjects s ON t.subject_id = s.id
                WHERE t.subject_id = :subject_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':subject_id', $subject_id, \PDO::PARAM_INT);
        $stmt->execute();

        $topics = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $topic = new SubjectTopicModel();
            $topic->setId($row['id']);
            $topic->setSubjectId($row['subject_id']);
            $topic->setName($row['name']);
            $topic->setSubjectName($row['subject_name']);
            $topic->setWeek($row['week']);

            $topics[] = $topic;
        }

        return $topics;
    }
}
