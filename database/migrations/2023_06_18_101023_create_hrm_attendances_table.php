<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('_employee')->default(0);
            $table->double('_number',15,4)->nullable();
            $table->integer('_type')->default(0);
            $table->dateTime('_datetime')->nullable();
            $table->integer('_user_id')->nullable();
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
        Schema::dropIfExists('hrm_attendances');
    }
}
