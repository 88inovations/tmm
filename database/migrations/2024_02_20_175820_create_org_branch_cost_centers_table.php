<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgBranchCostCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_branch_cost_centers', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('_branch_id');
            $table->integer('_cost_center_id');
            $table->integer('_master_id');
            $table->integer('_sales_person_id');
            $table->string('_table_name');
            $table->integer('_created_by');
            $table->integer('_updated_by');
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
        Schema::dropIfExists('org_branch_cost_centers');
    }
}
