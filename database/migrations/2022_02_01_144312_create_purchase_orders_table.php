<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('_order_number',100)->nullable();
            $table->date('_date')->nullable();
            $table->string('_time',50)->nullable();
            $table->unsignedBigInteger('_ledger_id');
            $table->foreign('_ledger_id')->references('id')->on('account_ledgers');
            $table->string('_referance')->nullable();
            $table->string('_address')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('_user_id');
            $table->foreign('_user_id')->references('id')->on('users');
            $table->string('_user_name')->nullable();
            $table->string('_note')->nullable();
            $table->double('_sub_total',15,4)->default(0);
            $table->double('_total',15,4)->default(0);
            $table->unsignedBigInteger('_branch_id');
            $table->foreign('_branch_id')->references('id')->on('branches');
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
        Schema::dropIfExists('purchase_orders');
    }
}
