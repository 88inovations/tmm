<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEmergenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_emergencies', function (Blueprint $table) {
            $table->id();
            $table->string('_name')->nullable();
            $table->string('_relationship')->nullable();
            $table->string('_mobile')->nullable();
            $table->string('_home')->nullable();
            $table->string('_work')->nullable();
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
        Schema::dropIfExists('hrm_emergencies');
    }
}
