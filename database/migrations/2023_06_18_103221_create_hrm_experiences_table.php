<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('_company')->nullable();
            $table->integer('_jobtitle_id')->nullable();
            $table->date('_wfrom')->nullable();
            $table->date('_wto')->nullable();
            $table->text('_note')->nullable();
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
        Schema::dropIfExists('hrm_experiences');
    }
}
