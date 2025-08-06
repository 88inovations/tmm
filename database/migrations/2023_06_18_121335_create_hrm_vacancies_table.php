<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('_name')->nullable();
            $table->integer('_jobtitle')->nullable();
            $table->integer('_hiring')->nullable();
            $table->integer('_nop')->nullable();
            $table->longText('_description')->nullable();
            $table->tinyInteger('_active')->nullable();
            $table->integer('_department_id')->nullable();
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
        Schema::dropIfExists('hrm_vacancies');
    }
}
