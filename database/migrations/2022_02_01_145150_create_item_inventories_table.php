<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('_item_id');
            $table->foreign('_item_id')->references('id')->on('inventories');
            $table->string('_item_name');
            $table->date('_date');
            $table->string('_time');
            $table->string('_transection');
            $table->integer('_transection_ref');
            $table->integer('_unit_id')->nullable();
            $table->integer('_category_id')->nullable();
            $table->integer('_transection_detail_ref_id');
            $table->double('_qty',15,4)->default(0);
            $table->double('_rate',15,4)->default(0);
            $table->double('_cost_rate',15,4)->default(0);
            $table->double('_value',15,4)->default(0);
            $table->double('_cost_value',15,4)->default(0);
            $table->unsignedBigInteger('_branch_id');
            $table->foreign('_branch_id')->references('id')->on('branches');
            $table->integer('_store_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_store_salves_id')->nullable();
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
        Schema::dropIfExists('item_inventories');
    }
}
