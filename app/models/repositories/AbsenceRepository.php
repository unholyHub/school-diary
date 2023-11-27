<?php

namespace App\Repositories;

use App\Constants\AbsenseType;
use PDO;
use App\Models\AbsenceModel;
use Config\Database as ConfigDatabase;

class AbsenceRepository
{
    private $db;

    public function __construct(ConfigDatabase $db)
    {
        $this->db = $db->getConnection();
    }

    public function createAbsence(AbsenceModel $absenceModel): bool
    {
        $sql = "INSERT INTO users_absences (user_id, subject_id, is_full, created_on) VALUES (:user_id, :subject_id, :is_full, :created_on)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':user_id', $absenceModel->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $absenceModel->getSubjectId(), PDO::PARAM_INT);
        $stmt->bindValue(':is_full', $absenceModel->getIsFull(), PDO::PARAM_BOOL);
        $stmt->bindValue(':created_on', $absenceModel->getCreatedOn(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updateAbsenceById(AbsenceModel $absenceModel): bool
    {
        $sql = "UPDATE 
                    users_absences 
                SET 
                    user_id = :user_id, 
                    subject_id = :subject_id, 
                    is_full = :is_full, 
                    created_on = :created_on 
                WHERE 
                    id = :absence_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':absence_id', $absenceModel->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $absenceModel->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $absenceModel->getSubjectId(), PDO::PARAM_INT);
        $stmt->bindValue(':is_full', $absenceModel->getIsFull(), PDO::PARAM_BOOL);
        $stmt->bindValue(':created_on', $absenceModel->getCreatedOn(), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteAbsenceById(int $absenceId): bool
    {
        $sql = "DELETE FROM absences WHERE id = :absence_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':absence_id', $absenceId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getAbsencesByUserId(int $userId): array
    {
        $sql = "SELECT * FROM users_absences WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $absences = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $absence = new AbsenceModel();
            $absence->setId($row['id']);
            $absence->setUserId($row['user_id']);
            $absence->setSubjectId($row['subject_id']);
            $absence->setIsFull($row['is_full']);
            $absence->setCreatedOn($row['created_on']);

            $absences[] = $absence;
        }

        return $absences;
    }

    public function getAbsencesByAbsenceId(int $absenceId): ?AbsenceModel
    {
        $sql = "SELECT * FROM users_absences WHERE id = :absence_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':absence_id', $absenceId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $absenceModel = new AbsenceModel();
            $absenceModel->setId($result['id']);
            $absenceModel->setUserId($result['user_id']);
            $absenceModel->setSubjectId($result['subject_id']);
            $absenceModel->setIsFull($result['is_full']);
            $absenceModel->setCreatedOn($result['created_on']);

            return $absenceModel;
        }

        return new AbsenceModel();
    }

    public function getAbsencesByUserIdAndSubjectId(AbsenceModel $absence): array
    {
        $sql = "SELECT * FROM users_absences WHERE user_id = :user_id AND subject_id = :subject_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $absence->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $absence->getSubjectId(), PDO::PARAM_INT);
        $stmt->execute();

        $absences = [];

        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $absence = new AbsenceModel();
            $absence->setId($result['id']);
            $absence->setUserId($result['user_id']);
            $absence->setSubjectId($result['subject_id']);
            $absence->setIsFull($result['is_full']);
            $absence->setCreatedOn($result['created_on']);

            $absences[] = $absence;
        }

        return $absences;
    }

    public function getAllAbsencesForUser(int $student_id)
    {
        $result = array(
            AbsenseType::PARTIAL_TEXT => 0,
            AbsenseType::FULL_TEXT => 0,
            AbsenseType::TOTAL_TEXT => 0
        );

        $query = "SELECT is_full FROM users_absences WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result[AbsenseType::TOTAL_TEXT] = count($results);

        foreach ($results as $row) {
            if ($row['is_full'] == AbsenseType::FULL) {
                $result[AbsenseType::FULL_TEXT]++;
            } else {
                $result[AbsenseType::PARTIAL_TEXT]++;
            }
        }

        return $result;
    }
}
