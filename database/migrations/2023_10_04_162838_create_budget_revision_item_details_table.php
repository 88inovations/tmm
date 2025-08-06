<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetRevisionItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_revision_item_details', function (Blueprint $table) {
            $table->id();
            $table->integer('_budget_id');
            $table->integer('_budget_revision_id');                           
            $table->integer('_item_id');
            $table->integer('_item_unit_id')->nullable();
            $table->string('_item_type')->nullable()->comment('Row,FG');
            $table->double('_item_qty')->default(0);
            $table->double('_item_unit_price')->default(0);
            $table->double('_item_budget_amount')->default(0);
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
        Schema::dropIfExists('budget_revision_item_details');
    }
}
