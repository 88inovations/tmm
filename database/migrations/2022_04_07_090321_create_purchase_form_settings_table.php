<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseFormSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_form_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('_default_inventory');
            $table->integer('_default_purchase');
            $table->integer('_default_discount');
            $table->integer('_default_vat_account');
            $table->integer('_opening_inventory');
            $table->integer('_default_capital');
            $table->integer('_show_barcode');
            $table->integer('_show_vat');
            $table->integer('_show_store');
            $table->integer('_show_self');
            $table->integer('_show_manufacture_date');
            $table->integer('_show_expire_date');
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
        Schema::dropIfExists('purchase_form_settings');
    }
}
