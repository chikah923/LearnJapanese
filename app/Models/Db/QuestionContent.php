<?php

namespace App\Models\Db;

use Illuminate\Database\Eloquent\Model;

class QuestionContent extends Model
{
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function question_bundle()
    {
        return $this->belongsTo(QuestionBundle::class);
    }

    public static function getByBundleId($question_bundle_id, $user_id = 1)
    {
        return self::where('user_id', $user_id) //とりあえず
                ->where('question_bundle_id', $question_bundle_id)
                ->whereNull('true_or_false')
                ->first();
    }

    public static function saveContent($question_bundle, $question, $question_number, $user_id = 1)
    {
            self::create([
                'question_bundle_id' => $question_bundle->id,
                'question_id' => $question->id,
                'question_number' => $question_number,
                'user_id' => $user_id, //とりあえず
            ]);
    }

    public static function getCorrectAnswerNumber($question_bundle_id)
    {
        return self::where('question_bundle_id', $question_bundle_id)
                ->where('true_or_false', true)
                ->count();
    }
}
