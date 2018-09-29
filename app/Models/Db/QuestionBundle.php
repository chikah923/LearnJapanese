<?php

namespace App\Models\Db;

use Illuminate\Database\Eloquent\Model;

class QuestionBundle extends Model
{
    protected $guarded = [];

    public function question_contents()
    {
        return $this->hasMany(QuestionContent::class);
    }

    public static function saveQuestionBundle($amount, $category, $user_id = 1)
    {
        return self::create([
            'amount' => $amount,
            'category' => $category,
            'user_id' => $user_id,
        ]);
    }

    public static function saveCorrectAnswerNumber($question_bundle_id, $correct_answer)
    {
        $question_bundle = self::findOrFail($question_bundle_id);
        $question_bundle->correct_number = $correct_answer;
        $question_bundle->update();
        return $question_bundle;
    }
}
