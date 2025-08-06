<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualReplaceMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_replace_masters', function (Blueprint $table) {
            $table->id();
            $table->string('_order_number')->nullable();
            $table->date('_date');
            $table->string('_time',60);
            $table->integer('_order_ref_id')->default(0)->comment('Complain Number');
            $table->string('_referance')->nullable();
            $table->string('_address')->nullable();
            $table->string('_phone')->nullable();
            $table->unsignedBigInteger('_customer_id');
            $table->foreign('_customer_id')->references('id')->on('account_ledgers');
            $table->unsignedBigInteger('_supplier_id');
            $table->foreign('_supplier_id')->references('id')->on('account_ledgers');
            $table->unsignedBigInteger('_user_id');
            $table->foreign('_user_id')->references('id')->on('users');
            $table->string('_user_name')->nullable();
            $table->string('_note')->nullable();
            $table->unsignedBigInteger('_branch_id');
            $table->foreign('_branch_id')->references('id')->on('branches');
            $table->integer('_store_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->string('_store_salves_id')->nullable();
            $table->integer('_delivery_man_id')->nullable();
            $table->integer('_sales_man_id')->nullable();
            $table->string('_sales_type',60)->nullable();
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_service_status')->default(0);
            $table->tinyInteger('_lock')->default(0);
             $table->integer('_apporoved_by')->nullable();
            $table->string('_service_by')->nullable();
            
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
        Schema::dropIfExists('individual_replace_masters');
    }
}
