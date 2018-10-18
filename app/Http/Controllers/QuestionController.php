<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\QuestionRepository;
use App\Repositories\QuestionContentRepository;
use App\Repositories\QuestionBundleRepository;
use App\Repositories\FavoriteQuestionRepository;
use Carbon\Carbon;

class QuestionController extends Controller
{
    private $question_repository;
    private $question_content_repository;
    private $question_bundle_repository;
    private $favorite_question_repository;

    public function __construct(
        QuestionRepository $question_repository,
        QuestionContentRepository $question_content_repository,
        QuestionBundleRepository $question_bundle_repository,
        FavoriteQuestionRepository $favorite_question_repository
    ) {
        $this->question_repository = $question_repository;
        $this->question_content_repository = $question_content_repository;
        $this->question_bundle_repository = $question_bundle_repository;
        $this->favorite_question_repository = $favorite_question_repository;
        $this->middleware('check.name');
    }

    public function getIndex()
    {
        return view('layouts.index');
    }

    public function showConfiguration(Request $request)
    {
        if (is_null($request->user())){
            return view ('questions.login_induce')->with([
                'category' => $request->query('category'),
            ]);
        }
        return view ('questions.configuration')->with([
            'category_lang' => trans('questions.category.'. $request->query('category')), //クエリパラメータから取得　あとでバリデーション
            'category' => $request->query('category'),
        ]);
    }

    public function showConfigurationWithoutLogin(Request $request)
    {
        return view ('questions.configuration')->with([
            'category_lang' => trans('questions.category.'. $request->query('category')),
            'category' => $request->query('category'),
        ]);
    }

    private function getUserId(Request $request)
    {
        return $request->user()->id ?? 1000;
    }

    public function getFirstQuestion(Request $request)
    {
        $input = $request->all();
        $amount = (int)array_get($input, 'amount');
        $category = (int)array_get($input, 'category');
        $user_id = $this->getUserId($request);
        $question_bundle = $this->question_bundle_repository->saveQuestionBundle($amount, $category, $user_id);
        $questions = $this->question_repository->getByUserConfig($amount, $category);

        $question_number = 0;
        foreach ($questions as $question) {
            $question_number++;
            $this->question_content_repository->saveContent($question_bundle, $question, $question_number, $user_id);
        }

        return view('questions.show')->with([
            'category_lang' => trans('questions.category.'.$questions[0]->category),
            'sub_category_lang' => trans('questions.sub_category.'.$questions[0]->sub_category),
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
        $question_content = $this->question_content_repository->getByBundleId($input['question_bundle_id']);
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
            'question_answer' => $question->option_.$input['question_answer'],
            'category_lang' => trans('questions.category.'.$question->category),
            'sub_category_lang' => trans('questions.sub_category.'.$question->sub_category),
            'question_bundle_id' => $input['question_bundle_id'],
            'last_question_flag' => $last_question_flag,
            'user' => $request->user(),
        ]);
    }

    public function getQuestionFromSecond(Request $request)
    {
        $input = $request->all();
        $question_content = $this->question_content_repository->getByBundleId($input['question_bundle_id']);
        $this->checkAndSaveFavoriteQuestion($input);

        return view('questions.show')->with([
            'category_lang' => trans('questions.category.'.$question_content->question->category),
            'sub_category_lang' => trans('questions.sub_category.'.$question_content->question->sub_category),
            'question' => $question_content->question,
            'question_number' => $question_content->question_number,
            'question_bundle_id' => $input['question_bundle_id'],
        ]);
    }

    public function getResult(Request $request)
    {
        $input = $request->all();
        $this->checkAndSaveFavoriteQuestion($input);
        $correct_answer = $this->question_content_repository->getCorrectAnswerNumber($input['question_bundle_id']);
        $question_bundle = $this->question_bundle_repository->saveCorrectAnswerNumber($input['question_bundle_id'], $correct_answer);

        return view('questions.result')->with([
            'amount' => $question_bundle->amount,
            'category' => $question_bundle->category,
            'category_lang' => trans('questions.category.'. $question_bundle->category),
            'correct_answer' => $correct_answer,
        ]);
    }


    private function checkAndSaveFavoriteQuestion($input)
    {
        if (isset($input['favorite_flag']) && !is_null($input['favorite_flag'])) {
            $this->favorite_question_repository->saveFavoriteQuestion($input['question_id'], Auth::user()->id);
        }
    }

    public function registerQuestion(Request $request)
    {
        $inputs = $request->all();
        $this->question_repository->create($inputs);
        return redirect("/register_questions");
    }
}
