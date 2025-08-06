<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('_type')->nullable();
            $table->string('_name')->nullable();
            $table->string('_subject')->nullable();
            $table->string('_organized')->nullable();
            $table->string('_place')->nullable();
            $table->string('_trfrom')->nullable();
            $table->string('_trto')->nullable();
            $table->string('_result')->nullable();
            $table->longText('_note')->nullable();

            $table->integer('_employee_id')->nullable();
            $table->integer('_user')->nullable();
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
        Schema::dropIfExists('hrm_trainings');
    }
}
