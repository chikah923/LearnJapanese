<?php

namespace App\Repositories;

use App\Models\Db\FavoriteQuestion;

class FavoriteQuestionRepository
{
    public function saveFavoriteQuestion($question_id, $user_id)
    {
        return FavoriteQuestion::saveFavoriteQuestion($question_id, $user_id);
    }

/*
    public function saveCorrectAnswerNumber($question_bundle_id, $correct_answer)
    {
        return QuestionBundle::saveCorrectAnswerNumber($question_bundle_id, $correct_answer);
    }
*/
}
