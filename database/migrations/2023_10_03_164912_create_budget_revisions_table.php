<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_revisions', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('_cost_center_id');
            $table->integer('_branch_id');
            $table->integer('_budget_id');
            $table->date('_revision_date');
            $table->longText('reason_for_revision')->nullable();
            $table->double('budget_amount')->default(0);
            $table->longText('_remarks')->nullable();
            $table->tinyInteger('_status')->default(1);
            $table->tinyInteger('_is_delete')->default(0);
            $table->integer('_created_by');
            $table->string('_user_name');
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
        Schema::dropIfExists('budget_revisions');
    }
}
