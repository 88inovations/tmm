<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('_item',200);
            $table->string('_code')->nullable();
            $table->string('_generic_name')->nullable();
            $table->string('_description')->nullable();
            $table->string('_strength')->nullable();
            $table->string('_item_category')->nullable();
            $table->string('_barcode')->nullable();
            $table->string('_oringin')->nullable();
            $table->string('_image')->nullable();
            $table->unsignedBigInteger('_category_id');
            $table->foreign('_category_id')->references('id')->on('item_categories');
            $table->double('_discount',15,4)->default(0);
            $table->integer('_brand_id')->nullable();
            $table->integer('_unit_id')->nullable();
            $table->integer('_warranty')->nullable();
            $table->double('_vat',15,4)->default(0);
            $table->double('_pur_rate',15,4)->default(0);
            $table->double('_sale_rate',15,4)->default(0);
            $table->double('_trade_price',15,4)->default(0);
            $table->double('_mrp_price',15,4)->default(0);
            $table->double('_reorder',15,2)->default(0);
            $table->double('_order_qty',15,2)->default(0);
            $table->double('_balance',15,2)->default(0);
            $table->double('_opening_qty',15,2)->default(0);
            $table->double('_serial',15,2)->default(0);
            $table->string('_manufacture_company')->nullable();
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_is_used')->default(0);
            $table->tinyInteger('_unique_barcode')->default(0);
            $table->tinyInteger('_kitchen_item')->default(0);//if 1 then this item will send to kitchen to cook/production and store deduct as per item ingredient wise
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
        Schema::dropIfExists('inventories');
    }
}
