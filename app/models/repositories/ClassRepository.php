<?php

namespace App\Repositories;

use App\Models\ClassModel;
use App\Models\UserModel;
use Config\Database;
use PDO;

class ClassRepository
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function get($id)
    {
        $sql = "SELECT * FROM classes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $class = new ClassModel();
            $class->setId($row['id']);
            $class->setClassNumber($row['number']);
            $class->setClassChar($row['div_char']);
            return $class;
        }

        return null;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM classes ORDER BY number, div_char";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $classes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $class = new ClassModel();
            $class->setId($row['id']);
            $class->setClassNumber($row['number']);
            $class->setClassChar($row['div_char']);

            $classes[] = $class;
        }

        return $classes;
    }

    public function search($searchTerm)
    {
        $searchTerm = str_replace(' ', '', $searchTerm);

        $sql = "SELECT * FROM classes WHERE CONCAT(CAST(number AS CHAR), div_char) LIKE :searchTerm";
        $stmt = $this->db->prepare($sql);
        $searchTerm = '%' . $searchTerm . '%';
        $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();

        $classes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $class = new ClassModel();
            $class->setId($row['id']);
            $class->setClassNumber($row['number']);
            $class->setClassChar($row['div_char']);
            $classes[] = $class;
        }

        return $classes;
    }

    public function create(ClassModel $class): bool
    {
        $sql = "INSERT INTO classes (number, div_char) VALUES (:classNumber, :classChar)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':classNumber', $class->getClassNumber());
        $stmt->bindValue(':classChar', $class->getClassChar());

        return $stmt->execute();
    }

    public function modify(ClassModel $class)
    {
        $sql = "UPDATE classes SET classes.number = :classNumber, classes.div_char = :classChar WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':classNumber', $class->getClassNumber());
        $stmt->bindValue(':classChar', $class->getClassChar());
        $stmt->bindValue(':id', $class->getId());

        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM classes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    public function checkClassExists(ClassModel $class)
    {
        $classId = $class->getId();

        $sql = "SELECT COUNT(*) as count FROM classes WHERE id = :classId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':classId', $classId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    public function checkClassExistsByName(ClassModel $class)
    {
        $classNumber = $class->getClassNumber();
        $classChar = $class->getClassChar();

        $sql = "SELECT COUNT(*) as count FROM classes WHERE number = :number AND div_char = :divChar";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':number', $classNumber, PDO::PARAM_INT);
        $stmt->bindParam(':divChar', $classChar, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    public function addUserToClass($class_id, $user_id)
    {
        $sql = "INSERT INTO user_classes (class_id, user_id) VALUES (:class_id, :user_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateStudentClass($class_id, $user_id)
    {
        $sql = "UPDATE user_classes SET class_id = :class_id WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        var_dump($count);
        return $count !== 0;
    }

    public function getClassByUserId($user_id)
    {
        $sql = "SELECT classes.* 
                FROM classes 
                INNER JOIN user_classes ON classes.id = user_classes.class_id 
                WHERE user_classes.user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return new ClassModel();
        }

        $class = new ClassModel();
        $class->setId($row['id']);
        $class->setClassNumber($row['number']);
        $class->setClassChar($row['div_char']);

        return $class;
    }

    public function getClassesBySubjectId($subjectId)
    {
        $sql = "SELECT c.*, s.name
            FROM classes c
            JOIN subjects s ON c.number BETWEEN s.min_starting_grade AND s.max_ending_grade
            WHERE s.id = :subject_id 
            ORDER BY c.number, c.div_char";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':subject_id', $subjectId, PDO::PARAM_INT);
        $stmt->execute();

        $classes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $class = new ClassModel();
            $class->setId($row['id']);
            $class->setClassNumber($row['number']);
            $class->setClassChar($row['div_char']);

            $classes[] = $class;
        }

        return $classes;
    }

    public function getClassesForTeacherSubjects($user_id)
    {
        $sql = "SELECT 
                    DISTINCT c.id, 
                    c.number, c.div_char 
                    FROM classes c 
                    INNER JOIN subjects s ON c.number BETWEEN s.min_starting_grade AND s.max_ending_grade
                    INNER JOIN user_subjects us ON us.subject_id = s.id
                    INNER JOIN users u ON u.id = us.user_id
                    WHERE 
                        u.id = :user_id 
                    ORDER BY 
                        c.number, c.div_char ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $classes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $class = new ClassModel();
            $class->setId($row['id']);
            $class->setClassNumber($row['number']);
            $class->setClassChar($row['div_char']);

            $classes[] = $class;
        }

        return $classes;
    }

    public function getAllStudents($class_id)
    {
        $sql = "SELECT u.* FROM users u
            INNER JOIN user_classes uc ON uc.user_id = u.id
            INNER JOIN classes c ON c.id = uc.class_id
            WHERE c.id = :class_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->execute();

        $students = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $student = new UserModel();
            $student->setId($row['id']);
            $student->setFirstName($row['first_name']);
            $student->setLastName($row['last_name']);
            // Add other properties of UserModel as needed

            $students[] = $student;
        }

        return $students;
    }

    public function getAllForStudentModification($student_id)
    {
        $sql = "SELECT
                    c.*
                FROM
                    classes c
                WHERE
                    c.number BETWEEN (
                        SELECT
                            c2.number
                        FROM
                            user_classes uc
                            INNER JOIN classes c2 ON uc.class_id = c2.id
                        WHERE
                            uc.user_id = :user_id
                        LIMIT
                            1
                    ) AND (
                        SELECT
                            c2.number + 1
                        FROM
                            user_classes uc
                            INNER JOIN classes c2 ON uc.class_id = c2.id
                        WHERE
                            uc.user_id = :user_id
                        LIMIT
                            1
                    )
                ORDER BY
                    c.number,
                    c.div_char ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();

        $classes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $class = new ClassModel();
            $class->setId($row['id']);
            $class->setClassNumber($row['number']);
            $class->setClassChar($row['div_char']);

            $classes[] = $class;
        }

        return $classes;
    }
}
