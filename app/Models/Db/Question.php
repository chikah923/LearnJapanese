<?php

namespace App\Models\Db;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['level', 'category', 'sub_category', 'question', 'option_1', 'option_2', 'option_3', 'option_4', 'answer','explanation'];

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
