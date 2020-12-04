<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('subject_id');
            $table->date('date');
            $table->time('time_start');
            $table->time('time_end');
            $table->string('classroom');
            $table->timestamps();

            $table->foreign('class_id')
                ->references('id')->on('school_classes')
                ->onDelete('cascade');
            $table->foreign('teacher_id')
                ->references('id')->on('teachers')
                ->onDelete('set null');
            $table->foreign('subject_id')
                ->references('id')->on('subjects')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetables');
    }
}
