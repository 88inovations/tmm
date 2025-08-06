<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_sheets', function (Blueprint $table) {
            $table->id();
             $table->integer('_month')->nullable();
            $table->integer('_year')->nullable();
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_voucher_id')->nullable();
            $table->string('_voucher_code')->nullable();
            $table->date('_date')->nullable();
            $table->decimal('salary_amount', 15, 2)->default(0);
            $table->decimal('allowance_amount', 15, 2)->default(0);
            $table->decimal('deduction_amount', 15, 2)->default(0);
            $table->decimal('net_payable_amount', 15, 2)->default(0);
            $table->text('_note')->nullable();
            $table->integer('approve_by_1')->default(0);
            $table->integer('approve_by_2')->default(0);
            $table->integer('approve_by_3')->default(0);
            $table->integer('approve_by_4')->default(0);
            $table->integer('_user_id')->default(0);
            $table->string('_user_name',60)->nullable();
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_lock')->default(0);
            $table->tinyInteger('_is_posting')->default(0);
            $table->tinyInteger('is_delete')->default(0);
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
        Schema::dropIfExists('salary_sheets');
    }
}
