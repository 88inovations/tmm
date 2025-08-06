<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionFromSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_from_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('_default_inventory');
            $table->integer('_production_account');
            $table->integer('_transit_account');
            $table->integer('_show_barcode');
            $table->integer('_show_store');
            $table->integer('_show_self');
            $table->integer('_show_cost_rate');
            $table->integer('_invoice_template');
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
        Schema::dropIfExists('production_from_settings');
    }
}
