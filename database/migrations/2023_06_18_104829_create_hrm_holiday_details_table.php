<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmHolidayDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_holiday_details', function (Blueprint $table) {
            $table->id();
            $table->string('_name')->nullable();
            $table->string('_type')->nullable();
            $table->date('_date')->nullable();
            $table->integer('_holidaysid')->defalut(0);
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
        Schema::dropIfExists('hrm_holiday_details');
    }
}
