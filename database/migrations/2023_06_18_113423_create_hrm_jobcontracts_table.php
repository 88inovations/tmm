<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmJobcontractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_jobcontracts', function (Blueprint $table) {
            $table->id();
            $table->string('_ctype')->nullable();
            $table->date('_csdate')->nullable();
            $table->date('_cedate')->nullable();
            $table->longText('_cdetail')->nullable();
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
        Schema::dropIfExists('hrm_jobcontracts');
    }
}
