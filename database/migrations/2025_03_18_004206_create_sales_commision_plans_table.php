<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesCommisionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_commision_plans', function (Blueprint $table) {
            $table->id();
            $table->date('_date')->nullable();
            $table->string('_name')->nullable();
            $table->date('_start_date')->nullable();
            $table->date('_end_date')->nullable();
            $table->string('_fescal_year')->nullable();
            $table->integer('organization_id')->default(0);
            $table->text('_details')->nullable();
            $table->tinyInteger('_status')->default(1);
            $table->tinyInteger('_is_delete')->default(0);
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
        Schema::dropIfExists('sales_commision_plans');
    }
}
