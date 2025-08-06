<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResturantFormSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resturant_form_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('_default_inventory');
            $table->integer('_default_sales');
            $table->integer('_default_cost_of_solds');
            $table->integer('_default_discount');
            $table->integer('_default_vat_account');
            $table->integer('_inline_discount');
            $table->integer('_default_service_charge');
            $table->integer('_default_other_charge');
            $table->integer('_default_delivery_charge');
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
            $table->integer('_show_p_balance');
            $table->integer('_defaut_customer')->nullable();
            $table->text('_cash_customer')->nullable();
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
        Schema::dropIfExists('resturant_form_settings');
    }
}
