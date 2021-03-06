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

    public function getByBundleId($question_bundle_id)
    {
        return QuestionContent::getByBundleId($question_bundle_id);
    }

    public function saveContent($question_bundle, $question, $question_number, $user_id)
    {
        QuestionContent::saveContent($question_bundle, $question, $question_number, $user_id);
    }

    public function getCorrectAnswerNumber($question_bundle_id)
    {
        return QuestionContent::getCorrectAnswerNumber($question_bundle_id);
    }

    public function getFailedQuestion($user_id, $category)
    {
        return (new QuestionContent())->getFailedQuestion($user_id, $category);
    }
}
