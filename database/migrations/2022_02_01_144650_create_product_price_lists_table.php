<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_price_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('_item_id');
            $table->foreign('_item_id')->references('id')->on('inventories');
            $table->string('_item')->nullable();
            $table->string('_input_type')->nullable();
            $table->string('_barcode')->nullable();
            $table->date('_manufacture_date')->nullable();
            $table->date('_expire_date')->nullable();
            $table->double('_qty',15,4)->default(0);
            $table->double('_sales_rate',15,4)->default(0);
            $table->double('_pur_rate',15,4)->default(0);
            $table->string('_sales_discount',50)->default(0)->comment('use % if or it will be amount');
            $table->string('_sales_vat',50)->default(0)->comment('use % if or it will be amount');
            $table->double('_value',15,4)->default(0);
            $table->integer('_unit_id')->nullable();
            $table->integer('_p_discount_input')->default(0);
            $table->integer('_p_discount_amount')->default(0);
            $table->integer('_p_vat')->default(0);
            $table->integer('_p_vat_amount')->default(0);
            $table->unsignedBigInteger('_purchase_detail_id');
            $table->foreign('_purchase_detail_id')->references('id')->on('purchase_details');
            $table->unsignedBigInteger('_branch_id');
            $table->foreign('_branch_id')->references('id')->on('branches');
            $table->integer('_store_id')->default(1);
            $table->integer('_cost_center_id')->default(1);
            $table->integer('_warranty')->default(0);
            $table->integer('_master_id')->nullable();
            $table->string('_store_salves_id',60)->nullable();
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_unique_barcode')->default(0);
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
        Schema::dropIfExists('product_price_lists');
    }
}
