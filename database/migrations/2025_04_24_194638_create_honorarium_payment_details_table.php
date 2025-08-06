<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHonorariumPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('honorarium_payment_details', function (Blueprint $table) {
            $table->id();
            $table->integer('_no')->nullable();
            $table->integer('_month')->nullable();
            $table->integer('_year')->nullable();
            $table->integer('_account_type_id')->nullable();
            $table->integer('_account_group_id')->nullable();
            $table->integer('_bill_master_id')->nullable();
            $table->integer('_bill_detail_id')->nullable();
            $table->integer('_ledger_id')->nullable();
            $table->integer('_sales_man_id')->nullable();
            $table->double('_amount',15,4)->default(0);
            $table->double('_paid_amount',15,4)->default(0);
            $table->double('_due_amount',15,4)->default(0);
            $table->string('_type',10)->nullable();
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id')->nullable();
            $table->integer('_cost_center')->nullable();
            $table->integer('_budget_id')->nullable();
            $table->string('_short_narr')->nullable();
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_is_close')->default(0);
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
        Schema::dropIfExists('honorarium_payment_details');
    }
}
