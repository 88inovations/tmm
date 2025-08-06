<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductIncentiveEarnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_incentive_earns', function (Blueprint $table) {
            $table->id();
            $table->integer('_item_id');
            $table->double('_unit_conversion',15,4)->default(0);
            $table->integer('_transection_unit');
            $table->integer('_base_unit');
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_budget_id')->nullable();
            $table->integer('_no');
            $table->double('_qty',15,4)->default(0);
            $table->double('_rate',15,4)->default(0);
            $table->double('_value',15,4)->default(0);
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
        Schema::dropIfExists('product_incentive_earns');
    }
}
