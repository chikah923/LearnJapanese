<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_questions', function (Blueprint $table) {
            $table->increments('id')->comment('管理ID');
            $table->unsignedInteger('question_id')->comment('問題番号');
            $table->unsignedInteger('user_id')->comment('ユーザID');
            $table->tinyInteger('remain_flag')->comment('表示可否');
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
