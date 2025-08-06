<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmWeekworkdaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_weekworkdays', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('_monday')->default(0);
            $table->tinyInteger('_tuesday')->default(0);
            $table->tinyInteger('_wednesday')->default(0);
            $table->tinyInteger('_thursday')->default(0);
            $table->tinyInteger('_friday')->default(0);
            $table->tinyInteger('_saturday')->default(0);
            $table->tinyInteger('_sunday')->default(0);
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
        Schema::dropIfExists('hrm_weekworkdays');
    }
}
