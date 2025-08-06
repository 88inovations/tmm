<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStmCollectionMasterDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stm_collection_master_details', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_no')->nullable();
            $table->integer('_student_id')->nullable();
            $table->integer('_bill_master_id')->nullable();
            $table->integer('_bill_detail_id')->nullable();
            $table->integer('_stm_division_id')->nullable();
            $table->integer('_class_id')->nullable();
            $table->integer('_bill_type')->nullable();
            $table->integer('_collection_ledger_id')->nullable();
            $table->double('_fee_amount',15,4)->default(0);
            $table->double('_discount_amount',15,4)->default(0);
            $table->double('_net_fee_amount',15,4)->default(0);
            $table->string('_remarks')->nullable();
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_is_close')->default(0);
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
        Schema::dropIfExists('stm_collection_master_details');
    }
}
