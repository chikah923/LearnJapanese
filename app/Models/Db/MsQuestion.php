<?php

namespace App\Models\Db;

use Illuminate\Database\Eloquent\Model;

class MsQuestion extends Model
{
    protected $fillable = ['level', 'category', 'sub_category', 'question', 'option_1', 'option_2', 'option_3', 'option_4', 'answer','explanation'];

    public static function getById($id)
    {
        return self::findOrFail($id);
    }

    public static function getByUserConfig($input)
    {

        $a = self::where('level', 1)
                //->where('category', 1)とりあえずsub_categoryは見ずに選ぶ
                ->inRandomOrder()
                //->limit($input['qs']) //key指定しないと取れない?tokenがついてくるが省いていいか
                ->limit(1)
                ->get();
        return $a;
    }

}
