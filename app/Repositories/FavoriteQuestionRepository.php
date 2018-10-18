<?php

namespace App\Repositories;

use App\Models\Db\FavoriteQuestion;

class FavoriteQuestionRepository
{
    public function saveFavoriteQuestion($question_id, $user_id)
    {
        return FavoriteQuestion::saveFavoriteQuestion($question_id, $user_id);
    }

    public function getFavoriteQuestion($user_id, $category)
    {
        return (new FavoriteQuestion())->getFavoriteQuestion($user_id, $category);
    }
}
