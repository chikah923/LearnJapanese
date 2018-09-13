<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_questions', function (Blueprint $table) {
            $table->increments('id')->comment('管理ID');
            $table->unsignedInteger('level')->comment('問題レベル');
            $table->unsignedInteger('category')->comment('問題カテゴリ');
            $table->unsignedInteger('sub_category')->comment('問題サブカテゴリ');
            $table->text('question')->comment('問題文');
            $table->string('option_1', 255)->comment('選択肢1');
            $table->string('option_2', 255)->comment('選択肢2');
            $table->string('option_3', 255)->comment('選択肢3');
            $table->string('option_4', 255)->comment('選択肢4');
            $table->unsignedInteger('answer')->comment('正解');
            $table->text('explanation')->comment('説明');
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
