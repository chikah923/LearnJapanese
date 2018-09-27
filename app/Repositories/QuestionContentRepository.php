<?php

namespace App\Repositories;

use App\Models\Db\QuestionContent;

class QuestionContentRepository
{
    public function saveTrueOrFalse($question_content, $true_or_false)
    {
        $question_content->true_or_false = $true_or_false;
        $question_content->update();
    }

    public function getByCreatedAt($created_at)
    {
        return QuestionContent::getByCreatedAt($created_at);
    }

    public function saveContent($question, $question_number)
    {
        QuestionContent::saveContent($question, $question_number);
    }
}
