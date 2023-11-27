<?php

namespace App\Models;

use App\Helpers\DateTimeHelper;

class SubjectScheduleModel
{
    private $id;
    private $userId;
    private $subjectId = -1;
    private $classId;
    private $scheduleDate;
    private $programSlot;
    private $programTimeStart;
    private $programTimeEnd;
    private $day;

    private $className;
    private $subjectName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    public function getSubjectId(): ?int
    {
        return $this->subjectId;
    }

    public function setSubjectId(?int $subjectId): void
    {
        $this->subjectId = $subjectId;
    }

    public function getClassId(): ?int
    {
        return $this->classId;
    }

    public function setClassId(?int $classId): void
    {
        $this->classId = $classId;
    }

    public function getScheduleDate(): ?string
    {
        return $this->scheduleDate;
    }

    public function setScheduleDate(?string $scheduleDate): void
    {
        $this->scheduleDate = $scheduleDate;
    }

    public function getProgramSlot(): ?int
    {
        return $this->programSlot;
    }

    public function setProgramSlot(?string $programSlot): void
    {
        $this->programSlot = $programSlot;
    }

    public function getProgramTimeStart(): ?string
    {
        return $this->programTimeStart;
    }

    public function setProgramTimeStart(?string $programTimeStart): void
    {
        $this->programTimeStart = $programTimeStart;
    }

    public function getProgramTimeEnd(): ?string
    {
        return $this->programTimeEnd;
    }

    public function setProgramTimeEnd(?string $programTimeEnd): void
    {
        $this->programTimeEnd = $programTimeEnd;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(?string $day): void
    {
        $this->day = $day;
    }

    public function getClassName(): ?string
    {
        return $this->className;
    }

    public function setClassName(?string $className): void
    {
        $this->className = $className;
    }

    // Get and Set function for subject name
    public function getSubjectName(): ?string
    {
        return $this->subjectName;
    }

    public function setSubjectName(?string $subjectName): void
    {
        $this->subjectName = $subjectName;
    }

    public function isStartTimeHigherThanEndTime(): bool
    {
        $startTime = strtotime($this->programTimeStart);
        $endTime = strtotime($this->programTimeEnd);

        return $startTime > $endTime;
    }
}
