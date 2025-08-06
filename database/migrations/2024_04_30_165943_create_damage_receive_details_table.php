<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamageReceiveDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damage_receive_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('_item_id');
            $table->foreign('_item_id')->references('id')->on('inventories');
            $table->longText('_barcode')->nullable();
            $table->double('_unit_conversion',15,4)->default(0);
            $table->integer('_transection_unit')->default(0);
            $table->integer('_base_unit')->default(0);
            $table->double('_qty',15,4)->default(0);
            $table->double('_rate',15,4)->default(0);
            $table->double('_sales_rate',15,4)->default(0);
            $table->double('_discount',15,4)->default(0);
            $table->double('_discount_amount',15,4)->default(0);
            $table->double('_vat',15,4)->default(0);
            $table->double('_vat_amount',15,4)->default(0);
            $table->double('_base_rate',15,4)->default(0);
            $table->double('_value',15,4)->default(0);
            $table->integer('_store_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_store_salves_id')->nullable();
            $table->date('_manufacture_date')->nullable();
            $table->date('_expire_date')->nullable();
            $table->unsignedBigInteger('_no');
            $table->foreign('_no')->references('id')->on('damage_receive_masters');
            $table->unsignedBigInteger('_branch_id');
            $table->foreign('_branch_id')->references('id')->on('branches');
            $table->integer('organization_id')->default(0);
            $table->tinyInteger('_status')->default(0);
            $table->string('_short_note',60)->nullable();
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
        Schema::dropIfExists('damage_receive_details');
    }
}
