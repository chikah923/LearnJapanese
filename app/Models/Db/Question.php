<?php

namespace App\Models\Db;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public static function getById($id)
    {
        return self::findOrFail($id);
    }

    public static function getByUserConfig($amount, $category)
    {
        return self::where('level', 1) //ログインユーザのレベルを分けた際に指定
                ->where('category', $category)
                ->inRandomOrder()
                ->limit($amount)
                ->get();
    }

}
