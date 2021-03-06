<?php

namespace App\Repositories;

use App\Models\Db\QuestionBundle;

class QuestionBundleRepository
{
    public function saveQuestionBundle($amount, $category, $user_id)
    {
        return QuestionBundle::saveQuestionBundle($amount, $category, $user_id);
    }

    public function saveCorrectAnswerNumber($question_bundle_id, $correct_answer)
    {
        return QuestionBundle::saveCorrectAnswerNumber($question_bundle_id, $correct_answer);
    }
}
