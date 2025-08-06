<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('_branch_id')->default(1);
            $table->string('_name');
            $table->integer('_number_of_chair')->nullable();
            $table->tinyInteger('_status')->default(0);
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
        Schema::dropIfExists('table_infos');
    }
}
