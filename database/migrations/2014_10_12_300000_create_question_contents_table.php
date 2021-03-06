<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_contents', function (Blueprint $table) {
            $table->increments('id')->comment('管理ID');
            $table->unsignedInteger('bundle_id')->comment('バンドルID');
            $table->unsignedInteger('question_id')->comment('問題ID');
            $table->unsignedInteger('question_number')->comment('問題番号');
            $table->unsignedInteger('user_id')->comment('ユーザID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_questions');
    }
}
