<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetImportCostDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_import_cost_details', function (Blueprint $table) {
            $table->id();
            $table->integer('_no')->nullable();
            $table->integer('_item_id')->nullable();
            $table->integer('_asset_category_id')->nullable();
            $table->string('_asset_name')->nullable();
            $table->integer('_unit_id')->nullable();
            $table->float('_qty',15,4)->default(0)->comment('Qty Wise Create data asset_item table and use this table id as ref');
            $table->float('_rate_usd',15,4)->default(0);
            $table->float('_cfr_value_usd',15,4)->default(0);
            $table->float('_cfr_value_bdt',15,4)->default(0);
            $table->float('_currency_rate_usd_to_bdt',15,4)->default(0);
            $table->float('_insurance_bdt',15,4)->default(0);
            $table->float('_lc_commision_bdt',15,4)->default(0);
            $table->float('_custom_duty_bdt',15,4)->default(0)->comment('Customs Duty & Taxes');
            $table->float('_rd',15,4)->default(0)->comment('Regular Duty');
            $table->float('_sd',15,4)->default(0)->comment('Supplementary Duty');
            $table->float('_vat',15,4)->default(0)->comment('Value Added Tax');
            $table->float('_at',15,4)->default(0)->comment('Advance Tax');
            $table->float('_atv',15,4)->default(0)->comment('Advance Trade Vat');
            $table->float('_custom_duty_tax_ait',15,4)->default(0)->comment('Customs Duty & Taxes (AIT)');
            $table->float('_custom_duty_tax_ait_2nd',15,4)->default(0)->comment('Customs Duty & Taxes (AT)  2nd');
            $table->float('_customer_other_charge_other',15,4)->default(0)->comment('Customs Charge(Other');
            $table->float('_port_charge',15,4)->default(0)->comment('Port Charge');
            $table->float('_port_charge_ait',15,4)->default(0)->comment('Port Charge(AIT)');
            $table->float('_shiping_agent_charge',15,4)->default(0)->comment('Shipping Agent Charge');
            $table->float('_shiping_agent_deduction_charge_2nd',15,4)->default(0)->comment('Shipping Agent Detention Charge-2nd');
            $table->float('_deport_charge',15,4)->default(0)->comment('Deport Charge');
            $table->float('_container_damage_charge',15,4)->default(0)->comment('Container Damage Charge');
            $table->float('_cnf_agen_commision',15,4)->default(0)->comment('CNFAgent Commission');
            $table->float('_installation_cost',15,4)->default(0)->comment('Installation Cost');
            $table->float('_other_cost',15,4)->default(0)->comment('Other Cost (Testing , Commissioning & Other)');
            $table->float('_total_initial_cost',15,4)->default(0)->comment('Total Initial Cost');
            $table->float('_salvage_value',15,4)->default(0)->comment('Salvage Value');
            $table->float('_depreciable_asset_value',15,4)->default(0)->comment('Depreciable Asset Value');
            $table->double('_cv',15,2)->default(0)->comment('Vat on C&F Commission');
            $table->double('_scv',15,2)->default(0)->comment('Vat on scaning fee');
            $table->double('_df',15,2)->default(0)->comment('Document Processing Fee');
            $table->double('_itc',15,2)->default(0)->comment('Income tax on C&F Commission');
            $table->double('_dfv',15,2)->default(0)->comment('Vat On Document Fee');
            $table->double('_pf',15,2)->default(0)->comment('Finess/Penalties');
            $table->text('_remarks')->nullable()->comment('Remarks');
            $table->float('_other_cost_bdt',15,4)->default(0);
            $table->float('_asset_value_bdt',15,4)->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('asset_import_cost_details');
    }
}
