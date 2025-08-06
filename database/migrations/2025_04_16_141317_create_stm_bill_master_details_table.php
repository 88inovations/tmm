<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStmBillMasterDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stm_bill_master_details', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_no')->nullable();
            $table->integer('_student_id')->nullable();
            $table->integer('_stm_division_id')->nullable();
            $table->integer('_class_id')->nullable();
            $table->integer('_bill_type')->nullable();
            $table->double('_fee_amount',15,4)->default(0);
            $table->double('_discount_amount',15,4)->default(0);
            $table->double('_net_fee_amount',15,4)->default(0);
            $table->double('_receive_amount',15,4)->default(0);
            $table->double('_due_amount',15,4)->default(0);
            $table->tinyInteger('_is_close')->default(0);
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
        Schema::dropIfExists('stm_bill_master_details');
    }
}
