<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmGuarantorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_guarantors', function (Blueprint $table) {
            $table->id();
            $table->string('_name')->nullable();
            $table->string('_father')->nullable();
            $table->string('_mother')->nullable();
            $table->string('_occupation')->nullable();
            $table->string('_workstation')->nullable();
            $table->string('_address1')->nullable();
            $table->string('_address2')->nullable();
            $table->string('_mobile')->nullable();
            $table->string('_email')->nullable();
            $table->string('_nationalid')->nullable();
            $table->string('_photo')->nullable();
            $table->string('_dob')->nullable();

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
        Schema::dropIfExists('hrm_guarantors');
    }
}
