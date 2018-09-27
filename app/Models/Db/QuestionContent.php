<?php

namespace App\Models\Db;

use Illuminate\Database\Eloquent\Model;

class QuestionContent extends Model
{
    protected $fillable = ['question_id', 'question_number', 'user_id', 'true_or_false'];

    public function question()
    {
        return $this->hasOne(Question::class);
    }

    public static function getByCreatedAt($created_at)
    {
        return self::where('user_id', 1) //とりあえず
                ->where('created_at', $created_at)
                ->whereNull('true_or_false')
                ->first();
    }

    public static function saveContent($question, $question_number)
    {
            self::create([
                'question_id' => $question->id,
                'question_number' => $question_number,
                'user_id' => 1, //とりあえず
            ]);
    }
}
