<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStmDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stm_divisions', function (Blueprint $table) {
            $table->id();
            $table->string('_name')->nullable();
            $table->string('_code')->nullable();
            $table->text('_detail')->nullable();
            $table->integer('_user_id')->nullable();
            $table->string('_user_name')->nullable();
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_lock')->default(0);
            $table->string('_created_by',60)->nullable();
            $table->string('_updated_by',60)->nullable();
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
        Schema::dropIfExists('stm_divisions');
    }
}
