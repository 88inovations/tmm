<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmItaxledgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_itaxledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('_ledger')->nullable();
            $table->double('_exlimit',15,4)->nullable();
            $table->integer('_ledgerno')->nullable();
            $table->integer('_user')->nullable();
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
        Schema::dropIfExists('hrm_itaxledgers');
    }
}
