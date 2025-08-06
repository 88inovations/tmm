<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStmBillCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stm_bill_collections', function (Blueprint $table) {
            $table->id();
            $table->date('_date');
            $table->integer('_ref_master_id')->nullable();
            $table->string('_voucher_code')->nullable();
            $table->integer('_ref_detail_id')->nullable();
            $table->string('_short_narration')->nullable();
            $table->string('_narration')->nullable();
            $table->string('_reference')->nullable();
            $table->string('_transaction')->nullable();
            $table->string('_voucher_type')->nullable();
            $table->string('_table_name')->nullable();
            $table->integer('_account_head')->nullable();
            $table->integer('_account_group')->nullable();
            $table->integer('_account_ledger')->nullable();
            $table->double('_dr_amount',15,4)->default(0);
            $table->double('_cr_amount',15,4)->default(0);
            $table->integer('organization_id')->default(0);
            $table->integer('_branch_id')->default(0);
            $table->integer('_cost_center')->default(0);
            $table->integer('_budget_id')->default(0);
            $table->integer('_sales_man_id')->default(0);
            $table->string('_fescal_period')->nullable();
            $table->string('_check_no')->nullable();
            $table->string('_check_number')->nullable();
            $table->date('_issue_date')->nullable();
            $table->date('_cash_date')->nullable();
            $table->string('_name')->nullable();
            $table->integer('_pair')->default(0);
            $table->tinyInteger('_status')->default(1);
            $table->double('_serial',15,4)->default(0);
            $table->double('_f_currency',15,4)->default(0);
            $table->double('_foreign_amount',15,4)->default(0);
            $table->integer('_user_id')->nullable();
            $table->string('_user_name')->nullable();
            $table->integer('_created_by')->nullable();
            $table->integer('_updated_by')->nullable();
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
        Schema::dropIfExists('stm_bill_collections');
    }
}
