<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLcMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_voucher_id')->nullable();
            $table->string('_voucher_code')->nullable();
            $table->date('_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->date('amendment_date')->nullable();
            $table->string('po_no')->nullable();
            $table->string('amendment_no')->nullable();
            $table->string('lc_ip_no')->unique(); //Lc No or IP_no
            $table->date('lc_ip_date');
            $table->string('bill_no')->nullable(); 
            $table->string('pi_no')->unique(); //Lc No or IP_no
            $table->date('pi_date')->nullable();
            $table->string('bill_of_enty_no')->nullable();
            $table->date('bill_of_enty_date')->nullable();
            $table->date('date_of_arrival')->nullable();
            $table->string('lc_type')->nullable();
            $table->string('lca_no')->nullable();
            $table->string('transport_type');
            $table->string('partial_shipment')->nullable();
            $table->string('bank')->nullable();;
            $table->string('supplier')->nullable();;
            $table->string('cnf')->nullable();
            $table->string('cnf_agent')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('insurance_company')->nullable();
            $table->string('insurance_cover_note')->nullable();
            $table->date('insurance_cover_date')->nullable();
            $table->string('lc_tt')->nullable();
            $table->string('currency')->nullable();;
            $table->double('_cif_value_foreign',15,4)->default(0);
            $table->double('_cif_value_local',15,4)->default(0);
            $table->double('_rate_to_bdt',15,4)->default(0);
            $table->double('_local_amount',15,4)->default(0);
            $table->text('remark')->nullable();
            $table->text('_note')->nullable();
             $table->tinyInteger('_is_close')->default(0);
            $table->integer('_user_id')->default(0);
            $table->string('_user_name',60)->nullable();
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_lock')->default(0);
            $table->tinyInteger('_is_posting')->default(0);
            $table->tinyInteger('is_delete')->default(0);
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
        Schema::dropIfExists('lc_masters');
    }
}
