<?php

namespace App\Repositories;

use App\Models\Db\Question;

class QuestionRepository
{
    public function create($inputs)
    {
        return Question::create($inputs);
    }

    public function getById($id)
    {
        return Question::getById($id);
    }

    public function getByUserConfig($amount, $category) //modelのメソッドと同じメソッド名になるのはok
    {
        return Question::getByUserConfig($amount, $category);
    }
}
