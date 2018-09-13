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

    public function getQuestion()
    {

    }

    public function registerQuestion(Request $request)
    {
        $inputs = $request->all();
        $this->question_repository->create($inputs);
        return redirect("/register_questions");
    }
}
