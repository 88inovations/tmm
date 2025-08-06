<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesCommisionPlanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_commision_plan_details', function (Blueprint $table) {
            $table->id();
            $table->integer('_no')->nullable();
            $table->double('_target_min',15,4)->default(0);
            $table->double('_target_max',15,4)->default(0);
            $table->double('_credit_limit',15,4)->default(0);
            $table->integer('_terms_id')->default(0);
            $table->double('_p_qty',15,4)->default(0);
            $table->double('_bonus_qty',15,4)->default(0);
            $table->double('_discount_rate',15,4)->default(0);
            $table->double('_cash_discount_rate',15,4)->default(0);
            $table->string('_gift_item')->nullable();
            $table->string('_grade')->nullable();
            $table->tinyInteger('_status')->default(1);
            $table->tinyInteger('_is_delete')->default(0);
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
        Schema::dropIfExists('sales_commision_plan_details');
    }
}
