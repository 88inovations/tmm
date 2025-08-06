<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucharCheckInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchar_check_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('_voucher_no');
            $table->string('_check_no');
            $table->date('_issue_date')->nullable();
            $table->date('_cash_date')->nullable();
            $table->tinyInteger('_status')->default(1);
            $table->tinyInteger('_is_delete')->default(0);
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
        Schema::dropIfExists('vouchar_check_infos');
    }
}
