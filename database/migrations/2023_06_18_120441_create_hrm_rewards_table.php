<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('_rcategory')->nullable();
            $table->string('_rtype')->nullable();
            $table->string('_rcause')->nullable();
            $table->longText('_rnote')->nullable();
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
        Schema::dropIfExists('hrm_rewards');
    }
}
