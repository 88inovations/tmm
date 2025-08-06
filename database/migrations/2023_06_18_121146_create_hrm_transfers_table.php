<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('_tfrom')->nullable();
            $table->string('_tto')->nullable();
            $table->date('_ttransfer')->nullable();
            $table->date('_tjoin')->nullable();
            $table->longText('_tnote')->nullable();

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
        Schema::dropIfExists('hrm_transfers');
    }
}
