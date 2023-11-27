<?php

namespace App\Repositories;

use PDO;
use App\Models\GradeModel;
use App\Views\GradeView;
use Config\Database;

class GradeRepository
{
    private $db;
    private $table = 'users_grades';

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function createGrade(GradeModel $grade)
    {
        $sql = "INSERT INTO $this->table (user_id, subject_id, grade, final_grade, term) 
                VALUES (:user_id, :subject_id, :grade, :final_grade, :term)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $grade->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $grade->getSubjectId(), PDO::PARAM_INT);
        $stmt->bindValue(':grade', $grade->getGrade(), PDO::PARAM_STR);
        $stmt->bindValue(':final_grade', $grade->getFinalGrade(), PDO::PARAM_STR);
        $stmt->bindValue(':term', $grade->getTerm(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getGradeById(int $id): GradeModel
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return new GradeModel();
        }

        $grade = new GradeModel();
        $grade->setId($row['id']);
        $grade->setUserId($row['user_id']);
        $grade->setSubjectId($row['subject_id']);
        $grade->setGrade($row['grade']);
        $grade->setFinalGrade($row['final_grade']);
        $grade->setTerm($row['term']);

        return $grade;
    }

    public function checkIfGradeExists(GradeModel $gradeModel)
    {
        $user_id = $gradeModel->getUserId();
        $subject_id = $gradeModel->getSubjectId();
        $term = $gradeModel->getTerm();

        $sql = "SELECT
                    id
                FROM
                    users_grades
                WHERE
                    user_id = :user_id AND 
                    subject_id = :subject_id AND 
                    term = :term AND 
                    grade IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->bindValue(':term', $term, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'] ?? -1;
    }

    public function updateGrade(GradeModel $gradeModel): bool
    {
        $id = $gradeModel->getId();
        $user_id = $gradeModel->getUserId();
        $subject_id = $gradeModel->getSubjectId();
        $term = $gradeModel->getTerm();
        $grade = $gradeModel->getGrade();
        $final_grade = $gradeModel->getFinalGrade();

        $sql = "UPDATE
                    users_grades
                SET
                    user_id = :user_id,
                    subject_id = :subject_id,
                    grade = :grade,
                    final_grade = :final_grade,
                    term = :term
                WHERE
                    id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':grade', $grade, PDO::PARAM_INT);
        $stmt->bindValue(':final_grade', $final_grade, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->bindValue(':term', $term, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function getGradesForSubject(GradeModel $grade)
    {
        $user_id = $grade->getUserId();
        $subject_id = $grade->getSubjectId();

        $sql = "SELECT 
                    *
                FROM
                    users_grades 
                WHERE 
                    user_id = :user_id AND subject_id = :subject_id  
                ORDER BY 
                    term, final_grade, id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->execute();

        $grades = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $grade = new GradeModel();
            $grade->setId($row['id']);
            $grade->setUserId($row['user_id']);
            $grade->setSubjectId($row['subject_id']);
            $grade->setGrade($row['grade']);
            $grade->setFinalGrade($row['final_grade']);
            $grade->setTerm($row['term']);

            $grades[] = $grade;
        }

        return $grades;
    }
}
