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
            'remain_flag' => true,
        ]);
    }

    public function getFavoriteQuestion($user_id, $category)
    {
        $query = $this->select('favorite_questions.*')
            ->where('user_id', $user_id)
            ->where('remain_flag', true)
            ->join('questions', function ($join) use ($category) {
                $join->on('favorite_questions.question_id', '=', 'questions.id')
                ->where('category', $category);
            });
        $query->orderBy('question_id');
        return $query->get()->unique('question_id');
    }
}
