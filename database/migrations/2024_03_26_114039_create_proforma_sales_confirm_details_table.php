<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformaSalesConfirmDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_sales_confirm_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('_item_id');
            $table->foreign('_item_id')->references('id')->on('inventories');
            $table->unsignedBigInteger('_p_p_l_id');
            $table->foreign('_p_p_l_id')->references('id')->on('product_price_lists');
            $table->tinyInteger('_show_invoice')->default(0);
            $table->text('_showing_item_name')->nullable();
            $table->text('_barcode')->nullable();
            $table->integer('_transection_unit')->default(1);
            $table->integer('_base_unit')->default(1);
            $table->double('_unit_conversion',15,4)->default(0);
            $table->double('_base_rate',15,4)->default(0);
            $table->double('_qty',15,4)->default(0);
            $table->double('_rate',15,4)->default(0);
            $table->double('_sales_rate',15,4)->default(0);
            $table->double('_discount',15,4)->default(0);
            $table->double('_discount_amount',15,4)->default(0);
            $table->double('_vat',15,4)->default(0);
            $table->double('_vat_amount',15,4)->default(0);
            $table->double('_value',15,4)->default(0);
            $table->date('_manufacture_date')->nullable();
            $table->date('_expire_date')->nullable();
            $table->string('_store_salves_id')->nullable();
            $table->unsignedBigInteger('_no');
            $table->foreign('_no')->references('id')->on('proforma_sales');
            $table->integer('_warranty')->nullable();
            $table->integer('organization_id');
            $table->integer('_branch_id');
            $table->integer('_cost_center_id');
            $table->integer('_store_id');
            $table->integer('_purchase_invoice_no')->nullable();
            $table->integer('_purchase_detail_id')->nullable();
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
        Schema::dropIfExists('proforma_sales_confirm_details');
    }
}
