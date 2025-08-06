<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInsentivePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_insentive_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->default(0);
            $table->integer('_branch_id')->default(0);
            $table->integer('_cost_center_id')->default(0);
            $table->integer('_budget_id')->default(0);
            $table->integer('_ledger_id')->default(0);
            $table->string('_fescal_year')->nullable();
            $table->integer('_incentive_group')->default(1)->comment('1=emloyee,2=customer,3=supplier');
            $table->string('_insentive_year')->nullable();
            $table->string('_insentive_quater_no')->nullable();
            $table->double('_incentive_rate',15,4)->default(0);
            $table->double('_total_amount',15,4)->default(0);
            $table->double('_incentive_amount',15,4)->default(0);
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
        Schema::dropIfExists('customer_insentive_payments');
    }
}
