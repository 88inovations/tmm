<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrantyFormSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warranty_form_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('_default_warranty_charge');
            $table->integer('_inline_discount');
            $table->integer('_show_barcode');
            $table->integer('_show_vat');
            $table->integer('_show_store');
            $table->integer('_show_self');
            $table->integer('_show_delivery_man');
            $table->integer('_show_sales_man');
            $table->integer('_show_cost_rate');
            $table->integer('_invoice_template');
            $table->integer('_show_warranty');
            $table->integer('_show_manufacture_date');
            $table->integer('_show_expire_date');
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
        Schema::dropIfExists('warranty_form_settings');
    }
}
