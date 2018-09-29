<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\QuestionRepository;
use App\Repositories\QuestionContentRepository;
use App\Repositories\QuestionBundleRepository;
use Carbon\Carbon;

class QuestionController
{
    private $question_repository;
    private $question_content_repository;

    public function __construct(
        QuestionRepository $question_repository,
        QuestionContentRepository $question_content_repository,
        QuestionBundleRepository $question_bundle_repository
    ) {
        $this->question_repository = $question_repository;
        $this->question_content_repository = $question_content_repository;
        $this->question_bundle_repository = $question_bundle_repository;
    }

    public function showConfiguration(Request $request)
    {
        return view ('questions.configuration')->with([
            //'category' => trans('questions.'. $request->query('category')), //クエリパラメータから取得　あとでバリデーション
            'category' => $request->query('category'),
        ]);
    }

    public function getFirstQuestion(Request $request)
    {
        $input = $request->all();
        $amount = (int)array_get($input, 'amount');
        $category = (int)array_get($input, 'category');
        //$user_id = Autn::user();
        $question_bundle = $this->question_bundle_repository->saveQuestionBundle($amount, $category); //user_idあとで
        $questions = $this->question_repository->getByUserConfig($amount, $category);

        $question_number = 0;
        foreach ($questions as $question) {
            $question_number++;
            $this->question_content_repository->saveContent($question_bundle, $question, $question_number); //あとでuser_idも
        }

        return view('questions.show')->with([
            'question' => $questions[0],
            'question_number' => 1,
            'question_bundle_id' => $question_bundle->id,
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
        $question_content = $this->question_content_repository->getByBundleId($input['question_bundle_id']); //Auth::user()->idのタイミング
        $this->question_content_repository->saveTrueOrFalse($question_content, $true_or_false);
        $new_question_content = $this->question_content_repository->getByBundleId($input['question_bundle_id']);

        $last_question_flag = false;
        if (is_null($new_question_content)) {
            $last_question_flag = true;
        }

        return view ('questions.true_or_false')->with([
            'question_number' => $question_content->question_number,
            'true_or_false' => $true_or_false,
            'question' => $question,
            'question_bundle_id' => $input['question_bundle_id'],
            'last_question_flag' => $last_question_flag,
        ]);
    }

    public function getQuestionFromSecond(Request $request)
    {
        $input = $request->all();
        $question_content = $this->question_content_repository->getByBundleId($input['question_bundle_id']); //Auth::user()->idのタイミング
        return view('questions.show')->with([
            'question' => $question_content->question,
            'question_number' => $question_content->question_number,
            'question_bundle_id' => $input['question_bundle_id'],
        ]);
    }

    public function getResult(Request $request)
    {
        $input = $request->all(); //question_bundle_idしか使わないけどallの方がいい?
        $correct_answer = $this->question_content_repository->getCorrectAnswerNumber($input['question_bundle_id']);
        $question_bundle = $this->question_bundle_repository->saveCorrectAnswerNumber($input['question_bundle_id'], $correct_answer);

        return view('questions.result')->with([
            'amount' => $question_bundle->amount,
            'category' => $question_bundle->category,
            'correct_answer' => $correct_answer,
        ]);
    }

    public function registerQuestion(Request $request)
    {
        $inputs = $request->all();
        $this->question_repository->create($inputs);
        return redirect("/register_questions");
    }
}
