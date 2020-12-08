<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_plans', function (Blueprint $table) {
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('hours_per_week');
            $table->unsignedInteger('hours_per_year');
            $table->timestamps();

            $table->foreign('subject_id')
                ->references('id')->on('subjects')
                ->onDelete('cascade');
            $table->foreign('class_id')
                ->references('id')->on('school_classes')
                ->onDelete('cascade');

            $table->primary(['subject_id', 'class_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_plans');
    }
}
