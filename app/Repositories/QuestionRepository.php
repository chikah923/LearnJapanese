<?php

namespace App\Repositories;

use App\Models\Db\MsQuestion;

class QuestionRepository
{
    public function create($inputs)
    {
        return MsQuestion::create($inputs);
    }

    public function getById($id)
    {
        return MsQuestion::getById($id);
    }

    public function getByUserConfig($input) //modelのメソッドと同じメソッド名になる、引数名分かりやすいものに変えるか
    {
        return MsQuestion::getByUserConfig($input);
    }
}
