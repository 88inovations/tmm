<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamageReceiveBarcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damage_receive_barcodes', function (Blueprint $table) {
            $table->id();
            $table->integer('_p_p_id');
            $table->integer('_item_id');
            $table->integer('_no_id');
            $table->integer('_no_detail_id');
            $table->integer('_qty')->default(1);
            $table->string('_barcode');
            $table->integer('_is_receive')->default(0);
            $table->integer('_is_send')->default(0);
            $table->integer('_is_stock')->default(0);
            $table->integer('_is_full_damage')->default(0);
            $table->tinyInteger('_status')->default(0);
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
        Schema::dropIfExists('damage_receive_barcodes');
    }
}
