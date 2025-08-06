<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentReceiveMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_receive_masters', function (Blueprint $table) {
            $table->id();
            $table->string('_order_number')->nullable();
            $table->date('_date');
            $table->string('_time',60);
            $table->unsignedBigInteger('_user_id');
            $table->foreign('_user_id')->references('id')->on('users');
            $table->string('_user_name')->nullable();
            $table->integer('_defalut_ledger_id')->nullable();
            $table->string('_note')->nullable();
            $table->string('_document')->nullable();
            $table->string('_voucher_type')->nullable();
            $table->string('_transection_type')->nullable();
            $table->string('_transection_for')->nullable()->comment('Supplier,Customer,Expense');
            $table->string('_transection_ref')->nullable();

            $table->string('_form_name')->nullable();
            $table->string('_bank_name')->nullable();
            $table->string('_branch_name')->nullable();
            $table->string('_bank_account')->nullable();
            $table->string('_issue_date')->nullable();
            $table->string('_cash_date')->nullable();
            $table->string('_check_no')->nullable();
            $table->double('_amount',15,4)->default(0);

            $table->unsignedBigInteger('_branch_id');
            $table->foreign('_branch_id')->references('id')->on('branches');
            $table->integer('organization_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_budget_id')->default(0);
            $table->integer('_sales_man_id')->nullable();
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
        Schema::dropIfExists('payment_receive_masters');
    }
}
