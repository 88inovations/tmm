<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetImportCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_import_costs', function (Blueprint $table) {
            $table->id();
            $table->string('_purchase_type')->nullable()->comment('Import,Local,Opening');
            $table->text('_voucher_number')->nullable()->comment('if multiple voucher available then use comma');
            $table->string('_order_number')->nullable();
            $table->string('_supplier_name')->nullable();
            $table->string('_bank_name')->nullable();
            $table->string('_branch_name')->nullable();
            $table->string('_lc_no')->nullable()->comment('LC/TT/PI No');
            $table->date('_lc_date')->nullable()->comment('LC/TT/PI Date');
            $table->string('_pi_no')->nullable()->comment('PI No');
            $table->date('_pi_date')->nullable()->comment('PI Date');
            $table->string('_invoice_no')->nullable()->comment('Invoice No');
            $table->date('_invoice_date')->nullable()->comment('Invoice Date');
            $table->string('_boe_no')->nullable()->comment('BoE No');
            $table->date('_boe_date')->nullable()->comment('Invoice Date');
            $table->string('_bl_no')->nullable()->comment('BL No');
            $table->date('_bl_date')->nullable()->comment('BL Date');
            $table->string('_incoterms')->nullable()->comment('Incoterms');
            $table->string('_import_currency')->nullable()->comment('Import Currency');
            $table->string('_currency_rate')->nullable()->comment('Currency Rate');
            $table->date('_date_of_arrival')->nullable()->comment('Date of Arrival');
            $table->string('_procurement_officer')->nullable()->comment('Procurement Officer');
            $table->string('_cnf_agent')->nullable()->comment('CNF Agent');
            $table->integer('_cnf_agent_id')->nullable()->comment('CNF Agent ID');
            $table->date('_date')->nullable();
            $table->date('_ammendment_date')->nullable()->comment('Amendment date ');
            $table->text('_ammendment_reason')->nullable()->comment('Amendment Reason ');
            $table->string('_bill_of_entry_no')->nullable();
            $table->text('_note')->nullable();
            $table->date('_bill_of_entry_date')->nullable();
            $table->double('_import_cost_foreign',15,4)->default(0)->comment('Import Cost (Foreign)');
            $table->double('_import_cost_local',15,4)->default(0)->comment('Import Cost (BD)');
            $table->tinyInteger('_lock')->default(1);
            $table->tinyInteger('_status')->default(0);
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
        Schema::dropIfExists('asset_import_costs');
    }
}
