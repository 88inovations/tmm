<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStmIncomeLedgerSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stm_income_ledger_setups', function (Blueprint $table) {
            $table->id();
            $table->integer('_admission_fee_ledger')->nullable();
            $table->integer('_tution_fee_ledger')->nullable();
            $table->integer('_anual_fee_ledger')->nullable();
            $table->integer('_exam_fee_ledger')->nullable();
            $table->integer('_monthly_food_fee_ledger')->nullable();
            $table->integer('_residential_fee_ledger')->nullable();
            $table->integer('_other_fee_ledger')->nullable();
            $table->integer('_other_2_fee_ledger')->nullable();
            $table->integer('_other_3_fee_ledger')->nullable();
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
        Schema::dropIfExists('stm_income_ledger_setups');
    }
}
