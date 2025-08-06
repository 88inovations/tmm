<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamageFromStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damage_from_stock_details', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('_item_id');
            $table->foreign('_item_id')->references('id')->on('inventories');
            $table->unsignedBigInteger('_p_p_l_id');
            $table->foreign('_p_p_l_id')->references('id')->on('product_price_lists');
            $table->text('_showing_item_name')->nullable();
            $table->string('_short_note')->nullable();
            $table->double('_unit_conversion',15,4)->default(0);
            $table->integer('_transection_unit')->default(0);
            $table->integer('_base_unit')->default(0);
            $table->tinyInteger('_is_free')->default(0);
            $table->double('sale_qty',15,4)->default(0);
            $table->double('free_qty',15,4)->default(0);
            $table->double('_qty',15,4)->default(0);
            $table->double('_base_rate',15,4)->default(0);
            $table->double('_rate',15,4)->default(0);
            $table->double('_sales_rate',15,4)->default(0);
            $table->double('_discount',15,4)->default(0);
            $table->double('_discount_amount',15,4)->default(0);
            $table->double('_vat',15,4)->default(0);
            $table->double('_vat_amount',15,4)->default(0);
            $table->double('_value',15,4)->default(0);
            $table->integer('_store_id')->nullable();
            $table->integer('_warranty')->default(0);
            $table->integer('organization_id')->default(1);
            $table->integer('_cost_center_id')->default(1);
            $table->string('_store_salves_id')->default(1);
            $table->string('_barcode')->nullable();
            $table->integer('_purchase_invoice_no')->nullable();
            $table->integer('_purchase_detail_id')->nullable();
            $table->date('_manufacture_date')->nullable();
            $table->date('_expire_date')->nullable();
            $table->unsignedBigInteger('_no');
            $table->foreign('_no')->references('id')->on('damage_from_stocks');
            $table->unsignedBigInteger('_branch_id');
            $table->foreign('_branch_id')->references('id')->on('branches');
            $table->tinyInteger('_show_invoice')->default(0);
            $table->tinyInteger('_status')->default(0);
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
        Schema::dropIfExists('damage_from_stock_details');
    }
}
