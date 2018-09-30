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

Route::view('/', 'layouts/index');
Route::get('/questions','QuestionController@showConfiguration');
Route::get('/questions_without_login', 'QuestionController@showConfigurationWithoutLogin');
Route::post('/questions/start', 'QuestionController@getFirstQuestion');
Route::post('/questions/answer', 'QuestionController@postAnswer');
Route::post('/questions/next', 'QuestionController@getQuestionFromSecond');
Route::post('/questions/result', 'QuestionController@getResult');

// Auth::routes();
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');

Route::view('/register_questions', 'questions/register');
Route::post('/register_questions', 'QuestionController@registerQuestion');
