<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostCenterAuthorisedChainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_center_authorised_chains', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('_branch_id');
            $table->integer('_cost_center_id');
            $table->integer('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->integer('erp_user_id')->nullable();
            $table->string('erp_user_name')->nullable();
            $table->double('ack_order')->nullable();
            $table->integer('ack_status')->nullable();
            $table->integer('is_visible')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('_status')->default(1);
            $table->date('ack_request_date')->nullable();
            $table->date('ack_updated_date')->nullable();
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
        Schema::dropIfExists('cost_center_authorised_chains');
    }
}
