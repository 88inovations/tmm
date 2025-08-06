<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEmpaddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_empaddresses', function (Blueprint $table) {
            $table->id();
            $table->string('_type')->nullable()->comment('present and parmanet address');
            $table->string('_address')->nullable();
            $table->string('_post')->nullable();
            $table->string('_police')->nullable()->comment('Thana');;
            $table->string('_district')->nullable();
            $table->string('_eaddress')->nullable();
            $table->integer('_user')->nullable();
            $table->integer('_employee_id');
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
        Schema::dropIfExists('hrm_empaddresses');
    }
}
