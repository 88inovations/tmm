<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmPayinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_payinfos', function (Blueprint $table) {
            $table->id();
            $table->integer('_ledger')->nullable();
            $table->double('_amount',15,4)->default(0);
            $table->string('_period')->nullable();
            $table->tinyInteger('_effect')->default(0);
            $table->integer('_payheads')->nullable();
            $table->integer('_payinfo_id')->nullable();
            $table->integer('_employee_id')->nullable();
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
        Schema::dropIfExists('hrm_payinfos');
    }
}
