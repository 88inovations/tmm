<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCylindarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cylindars', function (Blueprint $table) {
            $table->id();
            $table->date('_date')->nullable();
            $table->date('_receive_date')->nullable();
            $table->integer('_item_id')->nullable();
            $table->string('_cylidar_number')->nullable();
            $table->string('_curum')->nullable();
            $table->string('_length')->nullable();
            $table->integer('_purchase_id')->nullable();
            $table->double('_qty',15,4)->default(0);
            $table->string('_order_date')->nullable();
            $table->string('_order_by_customer')->nullable();
            $table->string('_delivery_by_supplier')->nullable();
            $table->string('_delivery_date')->nullable();
            $table->string('_return_date')->nullable();
            $table->string('_current_status')->nullable();
            $table->string('_current_store')->nullable();
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
        Schema::dropIfExists('cylindars');
    }
}
