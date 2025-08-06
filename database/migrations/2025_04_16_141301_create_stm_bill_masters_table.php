<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStmBillMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stm_bill_masters', function (Blueprint $table) {
            $table->id();
            $table->date('_date');
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->string('_order_number')->nullable(); //Admission fee or Monthly Fee
            $table->string('_bill_type')->nullable(); //Admission fee or Monthly Fee
            $table->integer('_month_id')->nullable();
            $table->string('_year')->nullable();
            $table->integer('_stm_division_id')->nullable();
            $table->integer('_class_id')->nullable();
            $table->integer('_voucher_id')->nullable();
            $table->string('_voucher_code')->nullable();
            $table->integer('_dr_ledger_id')->nullable();
            $table->integer('_cr_ledger_id')->nullable();
            $table->double('_number_of_student')->default(0);
            $table->double('_total_amount')->default(0);
            $table->double('_discount_amount')->default(0);
            $table->double('_net_amount')->default(0);
            $table->text('_note')->nullable();
            $table->integer('_user_id')->nullable();
            $table->string('_user_name')->nullable();
            $table->tinyInteger('_status')->default(0);
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
        Schema::dropIfExists('stm_bill_masters');
    }
}
