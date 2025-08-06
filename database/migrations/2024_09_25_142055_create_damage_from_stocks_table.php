<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamageFromStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damage_from_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('_order_number')->nullable();
            $table->date('_date');
            $table->date('payment_date')->nullable();
            $table->date('_delivery_date')->nullable();
            $table->string('_time',60);
            $table->string('_online_inv_no')->nullable();
            $table->string('track_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_mob_no')->nullable();
            $table->string('_mode_of_delivery')->nullable();
            $table->integer('_order_ref_id')->nullable();
            $table->integer('_payment_terms')->default(1);
            $table->string('_referance')->nullable();
            $table->string('_address')->nullable();
            $table->string('_phone')->nullable();
            $table->unsignedBigInteger('_ledger_id');
            $table->foreign('_ledger_id')->references('id')->on('account_ledgers');
            $table->unsignedBigInteger('_user_id');
            $table->foreign('_user_id')->references('id')->on('users');
            $table->string('_user_name')->nullable();
            $table->text('_note')->nullable();
            $table->text('_delivery_details')->nullable();
            $table->double('_sub_total',15,4)->default(0);
            $table->double('_discount_input',15,4)->default(0);
            $table->double('_total_discount',15,4)->default(0);
            $table->double('_total_vat',15,4)->default(0);
            $table->double('_total',15,4)->default(0);
            $table->double('_p_balance',15,4)->default(0);
            $table->double('_l_balance',15,4)->default(0);
            $table->double('_trans_amount',15,4)->default(0);
            $table->unsignedBigInteger('_branch_id');
            $table->foreign('_branch_id')->references('id')->on('branches');
            $table->integer('organization_id')->default(1);
            $table->integer('_store_id')->default(1);
            $table->integer('_cost_center_id')->default(1);
            $table->integer('_budget_id')->default(1);
            $table->string('_store_salves_id')->nullable();
            $table->integer('_delivery_man_id')->nullable();
            $table->integer('_sales_man_id')->nullable();
            $table->string('_sales_type',60)->nullable();
            $table->tinyInteger('_is_close')->default(0);
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_lock')->default(0);
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
        Schema::dropIfExists('damage_from_stocks');
    }
}
