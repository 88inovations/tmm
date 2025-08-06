<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResturantSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resturant_sales', function (Blueprint $table) {
            $table->id();
            $table->string('_order_number')->nullable();
            $table->date('_date');
            $table->string('_time',60);
            $table->integer('_type_of_service')->nullable();
            $table->string('_order_ref_id')->nullable();
            $table->string('_referance')->nullable();
            $table->string('_address')->nullable();
            $table->string('_table_id')->nullable();
            $table->string('_served_by_ids')->nullable();
            $table->string('_phone')->nullable();
            $table->unsignedBigInteger('_ledger_id');
            $table->foreign('_ledger_id')->references('id')->on('account_ledgers');
            $table->unsignedBigInteger('_user_id');
            $table->foreign('_user_id')->references('id')->on('users');
            $table->string('_user_name')->nullable();
            $table->string('_note')->nullable();
            $table->double('_sub_total',15,4)->default(0);
            $table->double('_discount_input',15,4)->default(0);
            $table->double('_total_discount',15,4)->default(0);
            $table->double('_total_vat',15,4)->default(0);
            $table->double('_service_charge',15,4)->default(0);
            $table->double('_other_charge',15,4)->default(0);
            $table->double('_delivery_charge',15,4)->default(0);
            $table->double('_total',15,4)->default(0);
            $table->double('_p_balance',15,4)->default(0);
            $table->double('_l_balance',15,4)->default(0);
            $table->unsignedBigInteger('_branch_id');
            $table->foreign('_branch_id')->references('id')->on('branches');
            $table->integer('_store_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->string('_store_salves_id')->nullable();
            $table->integer('_delivery_man_id')->nullable();
            $table->integer('_sales_man_id')->nullable();
            $table->string('_sales_type',60)->nullable(); //Sales/Hold
            $table->string('_sales_spot',60)->nullable(); //Spot Sales / Online Sales
            $table->string('_delivery_status',60)->nullable();//Order,Processing,Transit,Deliverd,Cancel
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_kitchen_status')->default(0); //0,1 done or not done
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
        Schema::dropIfExists('resturant_sales');
    }
}
