<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('_invoice_master_id');
            $table->string('_invoice_master_number')->nullable();
            $table->integer('_ref_id')->nullable();
            $table->tinyInteger('_tran_type')->default(0)->comment('1=receive,2=payment');
            $table->string('_table_name')->nullable();
            $table->double('_amount',15,4)->default(0);
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
        Schema::dropIfExists('invoice_payments');
    }
}
