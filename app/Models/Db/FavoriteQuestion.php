<?php

namespace App\Models\Db;

use Illuminate\Database\Eloquent\Model;

class FavoriteQuestion extends Model
{
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public static function saveFavoriteQuestion($question_id, $user_id)
    {
         self::create([
            'question_id' => $question_id,
            'user_id' => $user_id,
            'remain_flag' => 1,
        ]);
    }

/*
    public static function saveCorrectAnswerNumber($question_bundle_id, $correct_answer)
    {
        $question_bundle = self::findOrFail($question_bundle_id);
        $question_bundle->correct_number = $correct_answer;
        $question_bundle->update();
        return $question_bundle;
    }
*/
}
