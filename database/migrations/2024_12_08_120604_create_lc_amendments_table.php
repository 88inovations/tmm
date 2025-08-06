<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLcAmendmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_amendments', function (Blueprint $table) {
             $table->id();
            $table->foreignId('lc_master_id')->constrained('lc_masters')->onDelete('cascade');
            $table->string('amendment_no')->unique();
            $table->date('amendment_date');
            $table->string('amendment_type'); // Quantity Change, Amount Change, Date Change, etc.
            $table->double('old_cif_value_foreign', 15, 4)->default(0);
            $table->double('new_cif_value_foreign', 15, 4)->default(0);
            $table->date('old_expiry_date')->nullable();
            $table->date('new_expiry_date')->nullable();
            $table->string('reason_for_amendment')->nullable();
            $table->string('created_by', 60)->nullable();
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
        Schema::dropIfExists('lc_amendments');
    }
}
