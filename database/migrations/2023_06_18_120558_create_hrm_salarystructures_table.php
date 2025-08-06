<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmSalarystructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_salarystructures', function (Blueprint $table) {
            $table->id();
            $table->string('_month')->nullable();
            $table->string('_year')->nullable();
            $table->double('_paydays',15,4)->default(0);
            $table->double('_arrdays',15,4)->default(0);
            $table->string('_verify')->nullable();

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
        Schema::dropIfExists('hrm_salarystructures');
    }
}
