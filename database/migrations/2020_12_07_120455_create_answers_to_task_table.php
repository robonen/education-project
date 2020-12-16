<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers_to_task', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->smallInteger('mark')->nullable();
            $table->text('comment_by_teacher')->nullable();
            $table->boolean('checked')->default('0');
            $table->unsignedInteger('task_id');
            $table->unsignedInteger('student_id');
            $table->boolean('review')->default('0');
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')
                ->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers_to_task');
    }
}
