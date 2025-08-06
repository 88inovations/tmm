<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualReplaceOutItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_replace_out_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('_item_id');
            $table->foreign('_item_id')->references('id')->on('inventories');
            $table->integer('_p_p_l_id')->nullable();
            $table->date('_delivery_date')->nullable();
            $table->double('_qty',15,4)->default(0);
            $table->double('_rate',15,4)->default(0);
            $table->double('_sales_rate',15,4)->default(0);
            $table->double('_discount',15,4)->default(0);
            $table->double('_discount_amount',15,4)->default(0);
            $table->double('_vat',15,4)->default(0);
            $table->double('_vat_amount',15,4)->default(0);
            $table->double('_value',15,4)->default(0);
            $table->double('_adjust_amount',15,4)->default(0);
            $table->double('_net_total',15,4)->default(0);
            $table->integer('_store_id')->nullable();
            $table->integer('_warranty')->default(0);
            $table->integer('_cost_center_id')->nullable();
            $table->string('_store_salves_id')->nullable();
            $table->string('_barcode')->nullable();
            $table->string('_short_note')->nullable();
            $table->integer('_purchase_invoice_no')->nullable();
            $table->integer('_purchase_detail_id')->nullable();
            $table->date('_manufacture_date')->nullable();
            $table->date('_expire_date')->nullable();
            $table->unsignedBigInteger('_no');
            $table->foreign('_no')->references('id')->on('individual_replace_masters');
            $table->unsignedBigInteger('_branch_id');
            $table->foreign('_branch_id')->references('id')->on('branches');
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_out_status')->default(0);
            
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
        Schema::dropIfExists('individual_replace_out_items');
    }
}
