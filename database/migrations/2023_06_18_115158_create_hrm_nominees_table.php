<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_nominees', function (Blueprint $table) {
            $table->id();
            $table->string('_nname')->nullable();
            $table->string('_nfather')->nullable();
            $table->string('_nmother')->nullable();
            $table->date('_ndob')->nullable();
            $table->string('_nnationalid')->nullable();
            $table->string('_nmobile')->nullable();
            $table->string('_naddress1')->nullable();
            $table->string('_naddress2')->nullable();
            $table->string('_nrelation')->nullable();
            $table->string('_nbenefit')->nullable();
            $table->string('_nphoto')->nullable();

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
        Schema::dropIfExists('hrm_nominees');
    }
}
