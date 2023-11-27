<?php

namespace App\Controllers;

require_once './app/views/SubjectTopicView.php';

require_once './app/models/SubjectTopicModel.php';
require_once './app/models/repositories/SubjectTopicRepository.php';

use App\Models\SubjectTopicModel;
use App\Repositories\SubjectTopicRepository;

use Config\Database;

class SubjectTopicController
{
    private $subjectTopicRepository;

    public function __construct(Database $db)
    {
        $this->subjectTopicRepository = new SubjectTopicRepository($db);
    }

    public function createSubjectTopic(SubjectTopicModel $subjectTopic): bool
    {
        return $this->subjectTopicRepository->create($subjectTopic);
    }

    public function getSubjectTopicById(int $id): ?SubjectTopicModel
    {
        return $this->subjectTopicRepository->getById($id);
    }

    public function updateSubjectTopic(SubjectTopicModel $subjectTopic): bool
    {
        return $this->subjectTopicRepository->update($subjectTopic);
    }

    public function deleteSubjectTopic(int $id): bool
    {
        return $this->subjectTopicRepository->delete($id);
    }

    public function getAllTopicsBySubjectId($subject_id)
    {
        return $this->subjectTopicRepository->getAllTopicsBySubjectId($subject_id);
    }
}
