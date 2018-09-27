<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts/index');
});
Route::get('/questions','QuestionController@showConfiguration');
Route::post('/questions/start', 'QuestionController@getFirstQuestion');
Route::post('/questions/answer', 'QuestionController@postAnswer');
Route::post('/questions/next', 'QuestionController@getQuestionFromSecond');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::view('/register_questions', 'questions/register');
Route::post('/register_questions', 'QuestionController@registerQuestion');
