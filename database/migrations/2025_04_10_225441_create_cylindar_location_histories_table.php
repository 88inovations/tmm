<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCylindarLocationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cylindar_location_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('_no')->nullable();
            $table->date('_date')->nullable();
             $table->integer('_item_id')->nullable();
            $table->string('_cylidar_number')->nullable();
            $table->string('_curum')->nullable();
            $table->string('_length')->nullable();
            $table->integer('_purchase_id')->nullable();
            $table->double('_qty',15,4)->default(0);
            $table->date('_receive_date')->nullable();
            $table->string('_return_date')->nullable();
            $table->string('_previous_store')->nullable();
            $table->string('_current_store')->nullable();
             $table->string('_current_status')->nullable();
            $table->tinyInteger('_status')->default(1);
            $table->tinyInteger('_is_delete')->default(0);
            $table->string('_created_by',60)->nullable();
            $table->string('_updated_by',60)->nullable();
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
        Schema::dropIfExists('cylindar_location_histories');
    }
}
