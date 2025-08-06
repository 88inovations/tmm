<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrentyDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warrenty_dates', function (Blueprint $table) {
            $table->id();
            $table->integer('_item_id')->nullable();
            $table->integer('_p_p_l_id')->nullable();
            $table->integer('_master_id')->nullable();
            $table->integer('_detail_id')->nullable();
            $table->string('_trans_type')->nullable();
            $table->date('_start_date')->nullable();
            $table->date('_end_date')->nullable();
            $table->integer('_created_by')->nullable();
            $table->integer('_updated_by')->nullable();
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
        Schema::dropIfExists('warrenty_dates');
    }
}
