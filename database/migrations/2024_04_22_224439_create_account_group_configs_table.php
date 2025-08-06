<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountGroupConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_group_configs', function (Blueprint $table) {
            $table->id();
            $table->string('_employee_group')->nullable();
            $table->string('_direct_inc_exp_heads')->nullable();
            $table->string('_indirect_inc_exp_heads')->nullable();
            $table->string('_direct_income_group')->nullable();
            $table->string('_indirect_income_group')->nullable();
            $table->string('_direct_expense_group')->nullable();
            $table->string('_indirect_expense_group')->nullable();
            $table->string('_cash_group')->nullable();
            $table->string('_bank_group')->nullable();
            $table->string('_customer_group')->nullable();
            $table->string('_supplier_group')->nullable();
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
        Schema::dropIfExists('account_group_configs');
    }
}
