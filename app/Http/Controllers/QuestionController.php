<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\QuestionRepository;

class QuestionController
{
    private $question_repository;

    public function __construct(QuestionRepository $question_repository)
    {
        $this->question_repository = $question_repository;
    }

    public function getQuestion(Request $request)
    {
        $input = $request->all();
        $questions = $this->question_repository->getByUserConfig($input);
        //ユーザの設定した問題数を取ってくることはできたがどこに保持しておくか
        //出題履歴としてテーブルに残す?->あとあと何の問題やったか見れるが
        //ユーザ増えると容量がすごいことになるのでできれば他の方法で保持したい
        //とりあえず一問回答したときの処理を先に書く
        //レベル、カテゴリをどう受け取るか
        //それか、すべての問題を1ページにして返す　それぞれの問題に回答ボタンを置いてjsで解答表示　そのほうが実際の筆記試験に似てる
        $question = $questions->toArray();

        return view ('questions.show')->with([
            'question' => $questions[0],
        ]);
    }

    public function postUnswer(Request $request)
    {
        $input = $request->all();
        $true_or_false = false;
        if ($input['user_answer'] == $input['question_answer']) {
            $true_or_false = true;
        }
        $question = $this->question_repository->getById($input['question_id']);

        //誤答の場合、userと紐付けて問題をDBに登録

        return view ('questions.true_or_false')->with([
            'true_or_false' => $true_or_false,
            'question' => $question,
        ]);
    }

    public function registerQuestion(Request $request)
    {
        $inputs = $request->all();
        $this->question_repository->create($inputs);
        return redirect("/register_questions");
    }
}
