<?php

namespace App\Repositories;

use App\Models\SubjectScheduleModel;
use App\Views\SubjectScheduleView;
use Config\Database;

use PDO;

class SubjectScheduleRepository
{
    private $table = 'subject_schedules';

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function getById(int $id)
    {
        $sql = "SELECT * FROM subject_schedules WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return new SubjectScheduleModel();
        }

        $subjectSchedule = new SubjectScheduleModel();
        $subjectSchedule->setId($row['id']);
        $subjectSchedule->setUserId($row['user_id']);
        $subjectSchedule->setSubjectId($row['subject_id']);
        $subjectSchedule->setClassId($row['class_id']); // Add class_id
        $subjectSchedule->setProgramSlot($row['program_slot']); // Add program_slot
        $subjectSchedule->setProgramTimeStart($row['program_time_start']); // Add program_time_start
        $subjectSchedule->setProgramTimeEnd($row['program_time_end']); // Add program_time_end
        $subjectSchedule->setDay($row['day']); // Add day

        return $subjectSchedule;
    }

    public function createSubjectSchedule(SubjectScheduleModel $subjectSchedule)
    {
        $sql = "INSERT INTO $this->table 
            (user_id, subject_id, class_id, program_slot, program_time_start, program_time_end, day) 
            VALUES 
            (:user_id, :subject_id, :class_id, :program_slot, :program_time_start, :program_time_end, :day)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $subjectSchedule->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $subjectSchedule->getSubjectId(), PDO::PARAM_INT);
        $stmt->bindValue(':class_id', $subjectSchedule->getClassId(), PDO::PARAM_INT);
        $stmt->bindValue(':program_slot', $subjectSchedule->getProgramSlot(), PDO::PARAM_INT);
        $stmt->bindValue(':program_time_start', $subjectSchedule->getProgramTimeStart(), PDO::PARAM_STR);
        $stmt->bindValue(':program_time_end', $subjectSchedule->getProgramTimeEnd(), PDO::PARAM_STR);
        $stmt->bindValue(':day', $subjectSchedule->getDay(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updateSubjectSchedule(SubjectScheduleModel $subjectSchedule)
    {
        $sql = "UPDATE subject_schedules SET 
            user_id = :user_id, 
            subject_id = :subject_id, 
            class_id = :class_id,
            program_slot = :program_slot,       -- Add program_slot
            program_time_start = :program_time_start,       -- Add program_time_start
            program_time_end = :program_time_end,           -- Add program_time_end
            day = :day                -- Add day
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $subjectSchedule->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $subjectSchedule->getSubjectId(), PDO::PARAM_INT);
        $stmt->bindValue(':class_id', $subjectSchedule->getClassId(), PDO::PARAM_INT);
        $stmt->bindValue(':program_slot', $subjectSchedule->getProgramSlot(), PDO::PARAM_STR); // Bind program_slot
        $stmt->bindValue(':program_time_start', $subjectSchedule->getProgramTimeStart(), PDO::PARAM_STR); // Bind program_time_start
        $stmt->bindValue(':program_time_end', $subjectSchedule->getProgramTimeEnd(), PDO::PARAM_STR); // Bind program_time_end
        $stmt->bindValue(':day', $subjectSchedule->getDay(), PDO::PARAM_STR); // Bind day
        $stmt->bindValue(':id', $subjectSchedule->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function deleteSubjectSchedule(int $id)
    {
        $sql = "DELETE FROM subject_schedules WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getAllForUser($user_id): array
    {
        $sql = "SELECT 
                    sc.*,
                    CONCAT(c.number, c.div_char) AS class_name,
                    sub.name AS subject_name 
                FROM 
                    $this->table sc
                INNER JOIN
                    classes c
                ON
                    sc.class_id = c.id
                INNER JOIN
                    subjects sub
                ON
                    sc.subject_id = sub.id        
                WHERE 
                    user_id = :user_id
                ORDER BY
                    sc.program_slot ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();

        $schedules = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $schedule = new SubjectScheduleModel();
            $schedule->setId($row['id']);
            $schedule->setUserId($row['user_id']);

            $schedule->setSubjectId($row['subject_id']);
            $schedule->setSubjectName($row['subject_name']);

            $schedule->setClassId($row['class_id']);
            $schedule->setClassName($row['class_name']);

            $schedule->setProgramSlot($row['program_slot']);
            $schedule->setProgramTimeStart($row['program_time_start']);
            $schedule->setProgramTimeEnd($row['program_time_end']);
            $schedule->setDay($row['day']);

            $schedules[] = $schedule;
        }

        return $schedules;
    }

    public function isTimeSlotFree(SubjectScheduleModel $schedule): bool
    {
        $sql = "SELECT
                    COUNT(*) as count
                FROM
                    $this->table
                WHERE
                    class_id = :class_id
                    AND user_id = :user_id
                    AND day = :day
                    AND program_slot = :program_slot
                    AND (
                        (
                            program_time_start <= :program_time_start
                            AND program_time_end > :program_time_start
                        )
                        OR (
                            program_time_start < :program_time_end
                            AND program_time_end >= :program_time_end
                        )
                        OR (
                            program_time_start >= :program_time_start
                            AND program_time_end <= :program_time_end
                        )
                    )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':class_id', $schedule->getClassId(), PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $schedule->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':day', $schedule->getDay(), PDO::PARAM_INT);
        $stmt->bindValue(':program_slot', $schedule->getProgramSlot(), PDO::PARAM_INT);
        $stmt->bindValue(':program_time_start', $schedule->getProgramTimeStart(), PDO::PARAM_STR);
        $stmt->bindValue(':program_time_end', $schedule->getProgramTimeEnd(), PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = intval($result['count']);

        return $count === 0;
    }

    public function checkIfClassIdIsFree(SubjectScheduleModel $schedule): bool
    {
        $class_id = $schedule->getClassId();
        $day = $schedule->getDay();
        $program_time_start = $schedule->getProgramTimeStart();
        $program_time_end = $schedule->getProgramTimeEnd();

        $sql = "SELECT 
                    COUNT(*) as count 
                FROM 
                    subject_schedules
                WHERE 
                    class_id = :class_id AND 
                    day = :day AND 
                    (
                        (:start_time > program_time_start AND :start_time < program_time_end) OR 
                        (:end_time > program_time_start AND :end_time < program_time_end)
                    )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->bindValue(':day', $day, PDO::PARAM_INT);
        $stmt->bindValue(':start_time', $program_time_start);
        $stmt->bindValue(':end_time', $program_time_end);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0;
    }

    public function checkIfUserIdIsFree(SubjectScheduleModel $schedule): bool
    {
        $user_id = $schedule->getUserId();
        $day = $schedule->getDay();
        $program_time_start = $schedule->getProgramTimeStart();
        $program_time_end = $schedule->getProgramTimeEnd();

        $sql = "SELECT 
                    COUNT(*) as count 
                FROM 
                    subject_schedules
                WHERE 
                    user_id = :user_id AND 
                    day = :day AND 
                    (
                        (:start_time > program_time_start AND :start_time < program_time_end) OR 
                        (:end_time > program_time_start AND :end_time < program_time_end)
                    )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':day', $day, PDO::PARAM_INT);
        $stmt->bindValue(':start_time', $program_time_start);
        $stmt->bindValue(':end_time', $program_time_end);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0;
    }
}
