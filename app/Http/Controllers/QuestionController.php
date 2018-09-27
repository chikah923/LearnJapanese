<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\QuestionRepository;
use App\Repositories\QuestionContentRepository;
use Carbon\Carbon;

class QuestionController
{
    private $question_repository;
    private $question_content_repository;

    public function __construct(QuestionRepository $question_repository, QuestionContentRepository $question_content_repository)
    {
        $this->question_repository = $question_repository;
        $this->question_content_repository = $question_content_repository;
    }

    public function showConfiguration(Request $request)
    {
        return view ('questions.configuration')->with([
            'category' => $request->query('category'), //クエリパラメータから取得　あとでバリデーション
        ]);
    }

    public function getFirstQuestion(Request $request)
    {
        $input = $request->all();
        $amount = (int)array_get($input, 'amount');
        $category = (int)array_get($input, 'category');
        $questions = $this->question_repository->getByUserConfig($amount, $category);

        $question_number = 0;
        foreach ($questions as $question) {
            $question_number++;
            $this->question_content_repository->saveContent($question, $question_number); //あとでuser_idも
        }
        $created_at = Carbon::now();

        return view('questions.show')->with([
            'question' => $questions[0],
            'question_number' => 1,
            'created_at' => $created_at,
        ]);
    }

    public function postAnswer(Request $request)
    {
        $input = $request->all();
        $true_or_false = false;
        if ($input['user_answer'] == $input['question_answer']) {
            $true_or_false = true;
        }
        $question = $this->question_repository->getById($input['question_id']);

        //question_contentsテーブルにtrue_or_falseを一問ずつ保存
        $question_content = $this->question_content_repository->getByCreatedAt($input['created_at']); //Auth::user()->idのタイミング
        $last_question_flag = false;
        if (is_null($question_content)) {
            $last_question_flag = true;
        }
        $this->question_content_repository->saveTrueOrFalse($question_content, $true_or_false);

        return view ('questions.true_or_false')->with([
            'true_or_false' => $true_or_false,
            'question' => $question,
            'created_at' => $input['created_at'],
            'last_question_flag' => $last_question_flag,
        ]);
    }

    public function getQuestionFromSecond(Request $request)
    {
        $input = $request->all();
        $question_content = $this->question_content_repository->getByCreatedAt($input['created_at']); //Auth::user()->idのタイミング
dd($question_content->question());
        return view('questions.show')->with([
            'question' => $question_content->question(),
            'question_number' => $question_content->question_number,
            'created_at' => $input['created_at'],
        ]);
    }

    public function registerQuestion(Request $request)
    {
        $inputs = $request->all();
        $this->question_repository->create($inputs);
        return redirect("/register_questions");
    }
}
