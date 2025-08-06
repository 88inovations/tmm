<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuaterlyInsentiveSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quaterly_insentive_setups', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->default(0);
            $table->integer('_branch_id')->default(0);
            $table->integer('_cost_center_id')->default(0);
            $table->integer('_budget_id')->default(0);
            $table->string('_fescal_year')->nullable();
            $table->integer('_incentive_group')->default(1)->comment('1=emloyee,2=customer,3=supplier');
            $table->string('_insentive_year')->nullable();
            $table->string('_insentive_quater_no')->nullable();
            $table->date('_insentive_period_start')->nullable();
            $table->date('_insentive_period_end')->nullable();
            $table->string('_insentive_slap_no')->nullable();
            $table->double('_slap_min_amount')->default(0);
            $table->double('_slap_max_amount')->default(0);
            $table->double('_incentive_rate')->default(0);
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
        Schema::dropIfExists('quaterly_insentive_setups');
    }
}
