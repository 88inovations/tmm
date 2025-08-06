<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_item_details', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_budget_id')->nullable();
            $table->integer('_no')->nullable();
            $table->integer('_item_id');
            $table->integer('_transection_unit');
            $table->integer('_base_unit');
            $table->double('_unit_conversion',15,4)->default(1);
            $table->double('_qty',15,4)->default(0);
            $table->dateTime('_start_time');
            $table->dateTime('_end_time');
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
        Schema::dropIfExists('bonus_item_details');
    }
}
