<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankCheckInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_check_infos', function (Blueprint $table) {
           
            $table->id();
            $table->integer('_ledger_id');
            $table->string('_check_no');
            $table->text('_note')->nullable();
            $table->tinyInteger('_is_used')->default(0);
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
        Schema::dropIfExists('bank_check_infos');
    }
}
