<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStmDivisionClassStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stm_division_class_students', function (Blueprint $table) {
            $table->id();
            $table->integer('_student_id')->nullable();
            $table->integer('_division_id')->nullable();
            $table->integer('_class_id')->nullable();
            $table->string('_role_no')->nullable();
            $table->string('_session')->nullable();
            $table->string('_promoted')->nullable();
            $table->double('_admission_fee',15,4)->default(0);
            $table->double('_tution_fee',15,4)->default(0);
            $table->double('_anual_fee',15,4)->default(0);
            $table->double('_exam_fee',15,4)->default(0);
            $table->double('_other_fee',15,4)->default(0);
            $table->double('_other_2_fee',15,4)->default(0);
            $table->double('_other_3_fee',15,4)->default(0);
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_lock')->default(0);
            $table->string('_created_by',60)->nullable();
            $table->string('_updated_by',60)->nullable();
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
        Schema::dropIfExists('stm_division_class_students');
    }
}
