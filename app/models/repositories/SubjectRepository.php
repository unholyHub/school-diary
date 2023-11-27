<?php

namespace App\Models\Repositories;

use PDO;
use App\Models\SubjectModel;
use Config\Database;

class SubjectRepository
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function getAllsubjects(): array
    {
        $sql = "SELECT * FROM subjects";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $subjects = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subject = new SubjectModel();
            $subject->setId($row['id']);
            $subject->setName($row['name']);
            $subject->setMinStartingGrade($row['min_starting_grade']);
            $subject->setMaxEndingGrade($row['max_ending_grade']);
            $subject->setIsMain($row['is_main']);
            $subjects[] = $subject;
        }

        return $subjects;
    }

    public function getsubjectById($id)
    {
        $sql = "SELECT * FROM subjects WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return new SubjectModel();
        }

        $subject = new SubjectModel();
        $subject->setId($row['id']);
        $subject->setName($row['name']);
        $subject->setMinStartingGrade($row['min_starting_grade']);
        $subject->setMaxEndingGrade($row['max_ending_grade']);
        $subject->setIsMain($row['is_main']);

        return $subject;
    }

    // Function to create a new entry in the database
    public function create(SubjectModel $subject)
    {
        $sql = "INSERT INTO subjects (name, min_starting_grade, max_ending_grade, is_main) 
                VALUES (:name, :min_starting_grade, :max_ending_grade, :is_main)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':name', $subject->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':min_starting_grade', $subject->getMinStartingGrade(), PDO::PARAM_INT);
        $stmt->bindValue(':max_ending_grade', $subject->getMaxEndingGrade(), PDO::PARAM_INT);
        $stmt->bindValue(':is_main', $subject->getIsMain(), PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update(SubjectModel $subject)
    {
        // Prepare the SQL query
        $sql = "UPDATE subjects SET 
                name = :name, 
                min_starting_grade = :minStartingGrade,
                max_ending_grade = :maxEndingGrade,
                is_main = :is_main
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $name = $subject->getName();
        $minStartingGrade = $subject->getMinStartingGrade();
        $maxEndingGrade = $subject->getMaxEndingGrade();
        $isMain = $subject->getIsMain();
        $id = $subject->getId();

        //var_dump($id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':minStartingGrade', $minStartingGrade);
        $stmt->bindParam(':maxEndingGrade', $maxEndingGrade);
        $stmt->bindParam(':is_main', $isMain, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id);

        // Execute the query
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM subjects WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function searchSubjects($searchTerm)
    {
        // Remove all blank spaces from the search term
        $searchTerm = str_replace(' ', '', $searchTerm);

        // Prepare the SQL query with a parameter placeholder
        $sql = "SELECT * FROM subjects WHERE REPLACE(name, ' ', '') LIKE :searchTerm";

        // Prepare the statement
        $stmt = $this->db->prepare($sql);

        // Bind the search term with wildcard (assuming you want partial matching)
        $searchTerm = '%' . $searchTerm . '%';
        $stmt->bindParam(':searchTerm', $searchTerm, \PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Fetch all matching rows and convert them into SubjectModel objects
        $subjects = [];
        while ($row = $stmt->fetch()) {
            $subject = new SubjectModel();
            $subject->setId($row['id']);
            $subject->setName($row['name']);
            $subject->setMinStartingGrade($row['min_starting_grade']);
            $subject->setMaxEndingGrade($row['max_ending_grade']);
            $subject->setIsMain($row['is_main']);

            $subjects[] = $subject;
        }

        return $subjects;
    }

    public function getAllSubjetsByUserId($user_id): array
    {
        $subjects = [];

        $sql = "SELECT s.* FROM subjects s
                INNER JOIN user_subjects us 
                ON s.id = us.subject_id
                WHERE us.user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subject = new SubjectModel();
            $subject->setId($row['id']);
            $subject->setName($row['name']);
            $subject->setMinStartingGrade($row['min_starting_grade']);
            $subject->setMaxEndingGrade($row['max_ending_grade']);
            $subject->setIsMain($row['is_main']);

            $subjects[] = $subject;
        }

        return $subjects;
    }

    public function addTeacherToSubject($user_id, $subject_id)
    {
        $sql = "INSERT INTO user_subjects (user_id, subject_id) VALUES (:user_id, :subject_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function hasUserSubjectEntry($user_id, $subject_id)
    {
        $sql = "SELECT COUNT(*) FROM user_subjects WHERE user_id = :user_id AND subject_id = :subject_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->execute();

        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function getLinkedSubjectsByUserId($user_id)
    {
        $sql = "SELECT * FROM subjects WHERE id IN 
            (SELECT subject_id FROM user_subjects WHERE user_id = :user_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $unlinkedSubjects = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subject = new SubjectModel();
            $subject->setId($row['id']);
            $subject->setName($row['name']);
            $subject->setMinStartingGrade($row['min_starting_grade']);
            $subject->setMaxEndingGrade($row['max_ending_grade']);
            $subject->setIsMain($row['is_main']);
            $unlinkedSubjects[] = $subject;
        }

        return $unlinkedSubjects;
    }


    public function getLinkedSubjectsByUserIdAndSearchTerm($user_id, $searchTerm)
    {
        $searchTerm = str_replace(' ', '', $searchTerm);

        $sql = "SELECT * FROM subjects 
            WHERE id NOT IN (SELECT subject_id FROM user_subjects WHERE user_id = :user_id)
            AND (name LIKE :searchTerm OR min_starting_grade LIKE :searchTerm OR max_ending_grade LIKE :searchTerm)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();

        $linkedSubjects = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subject = new SubjectModel();
            $subject->setId($row['id']);
            $subject->setName($row['name']);
            $subject->setMinStartingGrade($row['min_starting_grade']);
            $subject->setMaxEndingGrade($row['max_ending_grade']);
            $subject->setIsMain($row['is_main']);
            $linkedSubjects[] = $subject;
        }

        return $linkedSubjects;
    }

    public function getUnlinkedSubjectsByUserId($user_id)
    {
        $sql = "SELECT * FROM subjects WHERE id NOT IN 
        (SELECT subject_id FROM user_subjects WHERE user_id = :user_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $unlinkedSubjects = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subject = new SubjectModel();
            $subject->setId($row['id']);
            $subject->setName($row['name']);
            $subject->setMinStartingGrade($row['min_starting_grade']);
            $subject->setMaxEndingGrade($row['max_ending_grade']);
            $subject->setIsMain($row['is_main']);
            $unlinkedSubjects[] = $subject;
        }

        return $unlinkedSubjects;
    }

    public function getUnlinkedSubjectsByUserIdAndSearchTerm($user_id, $searchTerm)
    {
        $searchTerm = str_replace(' ', '', $searchTerm);

        $sql = "SELECT * FROM subjects 
                WHERE id NOT IN (SELECT subject_id FROM user_subjects WHERE user_id = :user_id)
                AND (name LIKE :searchTerm OR min_starting_grade LIKE :searchTerm OR max_ending_grade LIKE :searchTerm)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();

        $unlinkedSubjects = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subject = new SubjectModel();
            $subject->setId($row['id']);
            $subject->setName($row['name']);
            $subject->setMinStartingGrade($row['min_starting_grade']);
            $subject->setMaxEndingGrade($row['max_ending_grade']);
            $subject->setIsMain($row['is_main']);
            $unlinkedSubjects[] = $subject;
        }

        return $unlinkedSubjects;
    }

    public function removeTeacherFromSubject($user_id, $subject_id)
    {
        $sql = "DELETE FROM user_subjects
            WHERE user_id = :user_id AND subject_id = :subject_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);

        $r = $stmt->execute();

        if (!$r) {
            $errorInfo = $stmt->errorInfo();
            $errorMessage = $errorInfo[2];
            var_dump($errorInfo);
            echo "Error: " . $errorMessage;
            exit or die();
        }

        return $r;
    }

    public function getClassesForStudentId($student_id, $teacher_id)
    {
        $sql = "SELECT DISTINCT s.*
            FROM subjects s
            INNER JOIN classes c ON c.number BETWEEN s.min_starting_grade AND s.max_ending_grade
            INNER JOIN user_classes uc ON uc.class_id = c.id
            INNER JOIN user_subjects us ON us.subject_id = s.id
            WHERE uc.user_id = :student_id AND us.user_id = :teacher_id
            ORDER BY 
                s.id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->execute();

        $subjects = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subject = new SubjectModel();
            $subject->setId($row['id']);
            $subject->setName($row['name']);
            $subject->setMinStartingGrade($row['min_starting_grade']);
            $subject->setMaxEndingGrade($row['max_ending_grade']);

            $subjects[] = $subject;
        }

        return $subjects;
    }

    public function getClassesForStudentIdWithGrades($student_id)
    {
        $sql = "SELECT
                    DISTINCT s.*
                FROM
                    subjects s
                    INNER JOIN classes c ON c.number 
                    BETWEEN s.min_starting_grade AND s.max_ending_grade
                    LEFT JOIN user_classes uc ON uc.class_id = c.id
                    LEFT JOIN users_grades ug ON ug.subject_id = s.id
                WHERE
                    uc.user_id = :student_id
                ORDER BY 
                    s.id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();

        $subjects = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subject = new SubjectModel();
            $subject->setId($row['id']);
            $subject->setName($row['name']);
            $subject->setMinStartingGrade($row['min_starting_grade']);
            $subject->setMaxEndingGrade($row['max_ending_grade']);
            $subject->setIsMain($row['is_main']);

            $subjects[] = $subject;
        }

        return $subjects;
    }
}
