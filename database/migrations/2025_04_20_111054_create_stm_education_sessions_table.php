<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStmEducationSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stm_education_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('_name');
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
        Schema::dropIfExists('stm_education_sessions');
    }
}
