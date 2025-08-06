<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusakFourPointThreeInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musak_four_point_three_inputs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('_no');
            $table->foreign('_no')->references('id')->on('musak_four_point_threes');
            $table->unsignedBigInteger('_item_id');
            $table->foreign('_item_id')->references('id')->on('inventories');
            $table->integer('_unit_id')->nullable();
            $table->string('_code')->nullable();
            $table->double('_qty',15,4)->default(0);
            $table->double('_rate',15,4)->default(0);
            $table->double('_value',15,4)->default(0);
            $table->double('_wastage_amt',15,4)->default(0);
            $table->double('_wastage_rate',15,4)->default(0);
            $table->tinyInteger('_status')->default(1);
            $table->tinyInteger('_last_edition')->default(1);
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
        Schema::dropIfExists('musak_four_point_three_inputs');
    }
}
