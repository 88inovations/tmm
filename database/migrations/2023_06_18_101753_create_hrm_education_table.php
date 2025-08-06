<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_education', function (Blueprint $table) {
            $table->id();
            $table->string('_level');
            $table->string('_subject');
            $table->string('_institute');
            $table->string('_year')->nullable();
            $table->string('_score')->nullable();
            $table->date('_edsdate')->nullable();
            $table->date('_ededate')->nullable();
            $table->integer('_user')->nullable();
            $table->integer('_employee_id');
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
        Schema::dropIfExists('hrm_education');
    }
}
