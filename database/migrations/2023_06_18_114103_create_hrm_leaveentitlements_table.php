<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmLeaveentitlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_leaveentitlements', function (Blueprint $table) {
             $table->id();
            $table->integer('_ltype')->nullable();
            $table->double('_lday',15,4)->nullable();
            $table->integer('_period')->nullable();
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
        Schema::dropIfExists('hrm_leaveentitlements');
    }
}
