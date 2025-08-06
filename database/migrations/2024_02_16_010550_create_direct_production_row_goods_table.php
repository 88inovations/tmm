<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectProductionRowGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_production_row_goods', function (Blueprint $table) {
            $table->id();
            $table->integer('_no');
            $table->integer('_item_id');
            $table->integer('_p_p_l_id');
            $table->string('_short_note')->nullable();
            $table->integer('_transection_unit');
            $table->integer('_base_unit');
            $table->double('_unit_conversion',15,4)->default(0);
            $table->double('_base_rate',15,4)->default(0);
            $table->double('_qty',15,4)->default(0);
            $table->double('_rate',15,4)->default(0);
            $table->double('_discount',15,4)->default(0);
            $table->double('_discount_amount',15,4)->default(0);
            $table->double('_vat',15,4)->default(0);
            $table->double('_vat_amount',15,4)->default(0);
            $table->double('_value',15,4)->default(0);
              $table->string('_warranty')->default(0);
             $table->longText('_barcode')->nullable();
            
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id');
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_store_id');
            $table->integer('_store_salves_id')->nullable();
            $table->date('_manufacture_date')->nullable();
            $table->date('_expire_date')->nullable();
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
        Schema::dropIfExists('direct_production_row_goods');
    }
}
