<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetRevisionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_revision_details', function (Blueprint $table) {
            $table->id();
            $table->integer('_budget_id');
            $table->integer('_budget_revision_id');
            $table->integer('_ledger_id');
            $table->string('_ledger_type')->comment('Account Ledger and inventory');
            $table->double('_budget_amount')->default(0);
            $table->tinyInteger('_status')->default(1);
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
        Schema::dropIfExists('budget_revision_details');
    }
}
