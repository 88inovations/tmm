<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusakFourPointThreeAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musak_four_point_three_additions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('_no');
            $table->foreign('_no')->references('id')->on('musak_four_point_threes');
            $table->unsignedBigInteger('_ledger_id');
            $table->foreign('_ledger_id')->references('id')->on('account_ledgers');
            $table->double('_amount',15,4)->default(0);
            $table->string('_short_narr')->nullable();
            $table->tinyInteger('_status')->default(1);
            $table->tinyInteger('_last_edition')->default(1);
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
        Schema::dropIfExists('musak_four_point_three_additions');
    }
}
