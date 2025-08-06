<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatWiseTaBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_wise_ta_bills', function (Blueprint $table) {
           $table->id();
            $table->string('_fescal_year')->nullable();
            $table->integer('_designation_id')->nullable();
            $table->double('_da_bill',15,4)->default(0);
            $table->double('_moto_bill',15,4)->default(0);
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_is_delete')->default(0);
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
        Schema::dropIfExists('cat_wise_ta_bills');
    }
}
