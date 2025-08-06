<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmSstructuredetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_sstructuredetails', function (Blueprint $table) {
           $table->id();
            $table->integer('_ledger')->nullable();
            $table->double('_amount',15,4)->default(0);
            $table->integer('_structureno')->default(0);
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
        Schema::dropIfExists('hrm_sstructuredetails');
    }
}
