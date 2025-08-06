<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('_employee')->default(0);
            $table->integer('_type')->default(0);
            $table->date('_start')->nullable();
            $table->date('_end')->nullable();
            $table->text('_note')->nullable();
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
        Schema::dropIfExists('assign_leaves');
    }
}
