<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('number');
            $table->string('letter', 1);
            $table->unsignedTinyInteger('count_students')->default(0);
            $table->string('profile');
            $table->unsignedInteger('classroom_teacher')->nullable();
            $table->timestamps();

            $table->foreign('classroom_teacher')
                ->references('id')->on('teachers')
                ->onDelete('set null');

            $table->unique(['number', 'letter']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_classes');
    }
}
