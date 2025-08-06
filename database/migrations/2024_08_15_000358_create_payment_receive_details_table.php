<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentReceiveDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_receive_details', function (Blueprint $table) {
            $table->id();
            $table->integer('_no');
            $table->string('_order_number')->comment('payment_receive_masters _order_number');
            $table->string('_table_name')->comment('sales,purchases,sales_returns,purchase_returns');
            $table->integer('_ref_id')->nullable()->comment('sales id ,purchases id,sales_return id');
            $table->string('_ref_order_number')->nullable()->comment('sales _order_number ,purchases _order_number,sales_return _order_number');
            $table->double('_p_d_able_amount')->default(0)->comment('payable or receivable Amount');
            $table->double('_p_d_amount')->default(0)->comment('Paid or Receive Amount');
            $table->double('_rest_amount')->default(0)->comment('Rest Amount');
            $table->integer('_branch_id')->default(0);
            $table->integer('organization_id')->default(0);
            $table->integer('_cost_center_id')->default(0);
            $table->integer('_budget_id')->default(0);
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
        Schema::dropIfExists('payment_receive_details');
    }
}
