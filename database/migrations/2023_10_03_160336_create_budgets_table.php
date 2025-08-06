<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('_cost_center_id');
            $table->integer('_branch_id');
            $table->date('_start_date');
            $table->date('_end_date');
            $table->double('budget_amount')->default(0);
            $table->double('_material_amount')->default(0);
            $table->double('_income_amount')->default(0);
            $table->double('_expense_amount')->default(0);
            $table->double('_project_value')->default(0);
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
        Schema::dropIfExists('budgets');
    }
}
