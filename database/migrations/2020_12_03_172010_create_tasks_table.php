<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->text('description')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->unsignedInteger('teacher_id')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->timestamps();
            $table->integer('subject_id');

            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onDelete('set null');

//            $table->foreign('class_id')->references('id')->on('school_classes')
//            ->onDelete('cascade');
//            $table->foreign('teacher_id')->references('id')->on('teachers')
//            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
