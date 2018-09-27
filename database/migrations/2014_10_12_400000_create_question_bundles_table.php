<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_bundles', function (Blueprint $table) {
            $table->increments('id')->comment('管理ID');
            $table->unsignedInteger('amount')->comment('問題数');
            $table->unsignedInteger('category')->comment('問題カテゴリ');
            $table->unsignedInteger('user_id')->comment('ユーザID');
            $table->unsignedInteger('correct_number')->comment('正答数');
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
