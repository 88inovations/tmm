<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmItaxrebatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_itaxrebates', function (Blueprint $table) {
            $table->id();
            $table->string('_rlevel')->nullable();
            $table->double('_rlimit',15,4)->nullable();
            $table->double('_rpercent',15,4)->nullable();
            $table->integer('_rebateno')->nullable();
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
        Schema::dropIfExists('hrm_itaxrebates');
    }
}
