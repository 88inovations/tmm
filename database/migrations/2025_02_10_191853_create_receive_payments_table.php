<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Customer Payment Receive
     */
    public function up()
    {
        Schema::create('receive_payments', function (Blueprint $table) {
            $table->id();
            $table->string('_order_number')->nullable();
            $table->date('_date');
            $table->string('_time',60);
            $table->integer('_user_id')->nullable();
            $table->string('_user_name')->nullable();
            $table->integer('_voucher_id')->nullable();
            $table->string('_voucher_code')->nullable();
            $table->integer('_defalut_ledger_id')->nullable();
            $table->string('_address')->nullable();
            $table->string('_phone')->nullable();
            $table->string('_note')->nullable();
            $table->string('_document')->nullable();
            $table->string('_voucher_type')->nullable();
            $table->string('_transection_type')->nullable();
            $table->string('_transection_ref')->nullable();
            $table->string('_form_name')->nullable();
            $table->string('_ref_table')->nullable();
            $table->double('_amount',15,4)->default(0);
            $table->double('_ledger_balance',15,4)->default(0);
            $table->integer('_ledger_id')->nullable(); //Ledger Main Customer 
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id')->default(0);
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_budget_id')->nullable();
            $table->integer('_sales_man_id')->nullable();
            $table->tinyInteger('_status')->default(1);
            $table->tinyInteger('_is_delete')->default(0);
            $table->tinyInteger('_lock')->default(0);
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
        Schema::dropIfExists('receive_payments');
    }
}
