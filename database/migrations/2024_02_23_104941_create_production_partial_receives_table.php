<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionPartialReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_partial_receives', function (Blueprint $table) {
           $table->id();
            $table->date('_date');
            $table->integer('_production_id')->nullable();
            $table->string('_production_order_number')->nullable();
            $table->date('_start_date')->nullable();
            $table->date('_end_date')->nullable();
            $table->integer('organization_id')->default(0);
            $table->integer('_branch_id')->default(0);
            $table->integer('_cost_center_id')->default(0);
            $table->integer('_budget_id')->default(0);
            $table->integer('_store_id')->default(0);
            $table->string('_note')->nullable();
            $table->string('_type')->nullable();
            $table->double('_stock_in__total',15,4)->default(0);
            $table->string('_p_status')->default("Pending");
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_lock')->default(0);
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
        Schema::dropIfExists('production_partial_receives');
    }
}
