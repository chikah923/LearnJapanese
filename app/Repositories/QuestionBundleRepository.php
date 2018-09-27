<?php

namespace App\Repositories;

use App\Models\Db\QuestionBundle;

class QuestionBundleRepository
{
    public function saveQuestionBundle($amount, $category)
    {
        return QuestionBundle::saveQuestionBundle($amount, $category);
    }
}
