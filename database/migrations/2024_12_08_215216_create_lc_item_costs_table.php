<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLcItemCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_item_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lc_master_id')->constrained('lc_masters')->onDelete('cascade');
            $table->string('_dr_ledgers')->nullable();
            $table->string('_cr_ledgers')->nullable();
            $table->integer('_voucher_id')->nullable();
            $table->integer('_voucher_code')->nullable();
            $table->integer('_item_id')->nullable();
            $table->string('_item_code')->nullable();
            $table->decimal('_unit_conversion', 15, 2)->default(0);
            $table->integer('_transection_unit')->nullable();; // Unit of Measurement
            $table->integer('_base_unit')->nullable();; // Unit of Measurement
            $table->decimal('_base_rate', 15, 2)->default(0);
            $table->decimal('_qty', 15, 2)->default(0);
            $table->decimal('item_quantity',15,4)->default(0);
            $table->decimal('_rate',15,4)->default(0);
            $table->decimal('_foreign_rate',15,4)->default(0);
            $table->decimal('_foreign_amount',15,4)->default(0);
            $table->decimal('_value', 15, 2)->default(0);
            $table->integer('organization_id')->default(0);
            $table->integer('_cost_center_id')->default(0);
            $table->integer('_branch_id')->default(0);
            $table->tinyInteger('_status')->default(1);
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
        Schema::dropIfExists('lc_item_costs');
    }
}
