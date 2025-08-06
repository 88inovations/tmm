<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusakFourPointThreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musak_four_point_threes', function (Blueprint $table) {
            $table->id();
            $table->date('_date');
            $table->integer('_item_id');
            $table->date('_first_delivery_date')->nullable();
            $table->double('_additional_vat_rate',15,4)->default(0);
            $table->double('_vat_amount',15,4)->default(0);
            $table->double('_cost_price',15,4)->default(0);
            $table->double('_sales_price',15,4)->default(0);
            $table->string('_responsible_person')->nullable();
            $table->string('_res_per_designation')->nullable();
            $table->tinyInteger('_status')->default(1);
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
        Schema::dropIfExists('musak_four_point_threes');
    }
}
