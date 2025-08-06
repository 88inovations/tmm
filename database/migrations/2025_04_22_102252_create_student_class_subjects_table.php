<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentClassSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_class_subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('_student_id');
            $table->integer('_class_id');
            $table->integer('_education_type');
            $table->text('_subjects')->nullable();
            $table->tinyInteger('_status')->default(1);
            $table->integer('_user_id')->nullable();
            $table->string('_user_name')->nullable();
            $table->integer('_created_by')->nullable();
            $table->integer('_updated_by')->nullable();
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
        Schema::dropIfExists('student_class_subjects');
    }
}
