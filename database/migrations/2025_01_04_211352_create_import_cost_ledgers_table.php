<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportCostLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_cost_ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('_insurance_bdt_ledger_id')->nullable();
            $table->integer('_lc_commision_bdt_ledger_id')->nullable();
            $table->integer('_custom_duty_bdt_ledger_id')->nullable();
            $table->integer('_custom_duty_tax_ait_ledger_id')->nullable();
            $table->integer('_custom_duty_tax_ait_2nd_ledger_id')->nullable();
            $table->integer('_customer_other_charge_other_ledger_id')->nullable();
            $table->integer('_port_charge_ledger_id')->nullable();
            $table->integer('_port_charge_ait_ledger_id')->nullable();
            $table->integer('_shiping_agent_charge_ledger_id')->nullable();
            $table->integer('_shiping_agent_deduction_charge_2nd_ledger_id')->nullable();
            $table->integer('_deport_charge_ledger_id')->nullable();
            $table->integer('_container_damage_charge_ledger_id')->nullable();
            $table->integer('_cnf_agen_commision_ledger_id')->nullable();
            $table->integer('_installation_cost_ledger_id')->nullable();
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
        Schema::dropIfExists('import_cost_ledgers');
    }
}
