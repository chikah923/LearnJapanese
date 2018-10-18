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

    public static function getByBundleId($question_bundle_id)
    {
        return self::where('question_bundle_id', $question_bundle_id)
                ->whereNull('true_or_false')
                ->first();
    }

    public static function saveContent($question_bundle, $question, $question_number, $user_id)
    {
            self::create([
                'question_bundle_id' => $question_bundle->id,
                'question_id' => $question->id,
                'question_number' => $question_number,
                'user_id' => $user_id,
            ]);
    }

    public static function getCorrectAnswerNumber($question_bundle_id)
    {
        return self::where('question_bundle_id', $question_bundle_id)
                ->where('true_or_false', true)
                ->count();
    }

    public function getFailedQuestion($user_id, $category) //お気に入り取得とほぼ同じなのでBaseModelクラス作って共通化してもいいかも
    {
        $query = $this->select('question_contents.*')
            ->where('user_id', $user_id)
            ->where('true_or_false', false)
            ->join('questions', function ($join) use ($category) {
                $join->on('question_contents.question_id', '=', 'questions.id')
                ->where('category', $category);
            });
        $query->orderBy('question_id');
        return $query->get()->unique('question_id');
    }
}
