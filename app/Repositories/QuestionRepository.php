<?php

namespace App\Repositories;

use App\Models\Db\MsQuestion;

class QuestionRepository
{
    public function create($inputs)
    {
        return MsQuestion::create($inputs);
    }

}
