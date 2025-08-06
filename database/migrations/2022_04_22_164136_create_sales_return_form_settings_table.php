<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesReturnFormSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_return_form_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('_default_inventory');
            $table->integer('_default_sales');
            $table->integer('_default_cost_of_solds');
            $table->integer('_default_discount');
            $table->integer('_default_vat_account');
            $table->integer('_inline_discount');
            $table->integer('_show_barcode');
            $table->integer('_show_vat');
            $table->integer('_show_store');
            $table->integer('_show_self');
            $table->integer('_show_delivery_man');
            $table->integer('_show_sales_man');
            $table->integer('_show_cost_rate');
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
        Schema::dropIfExists('sales_return_form_settings');
    }
}
