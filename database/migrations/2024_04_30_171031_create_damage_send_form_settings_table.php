<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamageSendFormSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damage_send_form_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('_default_inventory')->default(0);
            $table->integer('_default_purchase')->default(0);
            $table->integer('_default_discount')->default(0);
            $table->integer('_default_vat_account')->default(0);
            $table->integer('_opening_inventory')->default(0);
            $table->integer('_default_capital')->default(0);
            $table->integer('_show_short_note')->default(0);
            $table->integer('_show_unit')->default(0);
            $table->integer('_show_barcode')->default(0);
            $table->integer('_inline_discount')->default(0);
            $table->integer('_show_vat')->default(0);
            $table->integer('_show_store')->default(0);
            $table->integer('_show_self')->default(0);
            $table->integer('_show_manufacture_date')->default(0);
            $table->integer('_show_expire_date')->default(0);
            $table->integer('_show_p_balance')->default(0);
            $table->integer('_invoice_template')->default(0);
            $table->integer('_is_header')->default(0);
            $table->integer('_is_footer')->default(0);
            $table->string('_margin_top')->default(0);
            $table->string('_margin_bottom')->nullable();
            $table->string('_margin_left')->nullable();
            $table->string('_margin_right')->nullable();
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
        Schema::dropIfExists('damage_send_form_settings');
    }
}
