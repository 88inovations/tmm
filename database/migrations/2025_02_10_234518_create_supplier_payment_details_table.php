<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_payment_details', function (Blueprint $table) {
            $table->id();
            $table->integer('_no')->nullable();
            $table->string('_voucher_code')->nullable();
            $table->integer('_ref_id')->nullable();
            $table->string('_table')->nullable();
            $table->string('_invoice_id')->nullable();
            $table->string('_invoice_number')->nullable();
            $table->double('_total',15,4)->nullable();
            $table->double('_receive_amount',15,4)->nullable();
            $table->double('_due_amount',15,4)->nullable();
            $table->double('_collection_amount',15,4)->nullable();
            $table->double('_due_balance',15,4)->nullable();
            $table->string('_type')->nullable();
            $table->integer('_sales_man_id')->nullable();
            $table->text('_short_narr')->nullable();
            $table->tinyInteger('_is_adjust')->default(0);
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
        Schema::dropIfExists('supplier_payment_details');
    }
}
