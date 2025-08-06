<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_languages', function (Blueprint $table) {
            $table->id();
            $table->string('_language')->nullable();
            $table->string('_fluency')->nullable();
            $table->string('_competency')->nullable();
            $table->longText('_lnote')->nullable();
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
        Schema::dropIfExists('hrm_languages');
    }
}
