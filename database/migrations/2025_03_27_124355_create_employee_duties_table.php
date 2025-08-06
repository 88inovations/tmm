<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDutiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_duties', function (Blueprint $table) {
            $table->id();
            $table->integer('_branch_id')->default(0);
            $table->integer('_employee_id')->nullable();
            $table->date('_date')->nullable();
            $table->string('_time')->nullable();
            $table->string('village')->nullable();
            $table->string('union')->nullable();
            $table->string('thana')->nullable();
            $table->string('zilla')->nullable();
            $table->string('country')->nullable();
            $table->text('full_address')->nullable();

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
        Schema::dropIfExists('employee_duties');
    }
}
