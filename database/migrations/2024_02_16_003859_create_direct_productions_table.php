<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_productions', function (Blueprint $table) {
            $table->id();
            $table->date('_date');
            $table->date('_start_date')->nullable();
            $table->date('_end_date')->nullable();
            $table->string('_reference')->nullable();
            $table->string('_quatation_no')->nullable();
            $table->string('_sales_order_no')->nullable();
            $table->integer('_pm_id')->nullable();
            $table->integer('_apporoved_by_id')->nullable();
            $table->integer('_sales_man_id')->nullable();
            $table->integer('organization_id')->default(0);
            $table->integer('_branch_id')->default(0);
            $table->integer('_cost_center_id')->default(0);
            $table->integer('_budget_id')->default(0);
            $table->integer('_store_id')->default(0);
            $table->string('_note')->nullable();
            $table->string('_type')->nullable();
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
        Schema::dropIfExists('direct_productions');
    }
}
