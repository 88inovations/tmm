<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmItaxpayablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_itaxpayables', function (Blueprint $table) {
            $table->id();
            $table->string('_plevel')->nullable();
            $table->double('_plimit',15,4)->nullable();
            $table->double('_ppercent',15,4)->nullable();
            $table->integer('_payableno')->nullable();
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
        Schema::dropIfExists('hrm_itaxpayables');
    }
}
