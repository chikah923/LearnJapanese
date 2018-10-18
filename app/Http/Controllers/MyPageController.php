<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\QuestionRepository;
use App\Repositories\QuestionContentRepository;
use App\Repositories\QuestionBundleRepository;
use App\Repositories\FavoriteQuestionRepository;
use Carbon\Carbon;

class MyPageController extends Controller
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
        $this->middleware('auth');  //めちゃ便利、これだけでこのコントローラ通るもの全てログインチェックできる
    }

    public function getIndex()
    {
        return view('layouts.mypage_index');
    }

    public function getFavoriteIndex(Request $request)
    {
        return view('mypage.favorite_index');
    }

    public function getFailedIndex(Request $request)
    {
        return view('mypage.failed_index');
    }

    public function getFavoriteQuestion(Request $request)
    {
        $category = $request->query('category');
        $favorite_questions = $this->favorite_question_repository->getFavoriteQuestion(Auth::user()->id, $category);

        return view('mypage.favorite_question')->with([
            'category_lang' => trans('questions.category.'.$category),
            'favorite_questions' => $favorite_questions,
            'count' => $favorite_questions->count(),
        ]);
    }

    public function getFailedQuestion(Request $request)
    {
        $category = $request->query('category');
        $failed_questions = $this->question_content_repository->getFailedQuestion(Auth::user()->id, $category);

        return view('mypage.failed_question')->with([
            'category_lang' => trans('questions.category.'.$category),
            'failed_questions' => $failed_questions,
            'count' => $failed_questions->count(),
        ]);
    }
}
