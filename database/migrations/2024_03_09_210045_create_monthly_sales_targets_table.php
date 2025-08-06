<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlySalesTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_sales_targets', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->default(0);
            $table->integer('_branch_id')->default(0);
            $table->integer('_cost_center_id')->default(0);
            $table->integer('_budget_id')->default(0);
            $table->string('_fescal_year')->nullable();
            $table->integer('_ledger_id')->nullable();
            $table->integer('_group')->default(1)->comment('1=emloyee,2=customer,3=supplier');
            $table->integer('_year')->nullable();
            $table->integer('_month_no')->nullable();
            $table->date('_period_start')->nullable();
            $table->date('_period_end')->nullable();
            $table->double('_target_amount')->default(0);
            $table->double('_sales_amount')->default(0);
            $table->double('_sales_return_amount')->default(0);
            $table->double('_collection_amount')->default(0);
            $table->tinyInteger('_is_sms')->default(0);
            $table->tinyInteger('_is_close')->default(0);
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
        Schema::dropIfExists('monthly_sales_targets');
    }
}
