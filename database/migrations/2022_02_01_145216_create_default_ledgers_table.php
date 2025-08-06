<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('_sales');
            $table->integer('_sales_return');
            $table->integer('_purchase');
            $table->integer('_purchase_return');
            $table->integer('_sales_vat');
            $table->integer('_purchase_vat');
            $table->integer('_purchase_discount');
            $table->integer('_sales_discount');
            $table->integer('_inventory');
            $table->integer('_cost_of_sold');
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
        Schema::dropIfExists('default_ledgers');
    }
}
