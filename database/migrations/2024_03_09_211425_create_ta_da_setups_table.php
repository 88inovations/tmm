<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaDaSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ta_da_setups', function (Blueprint $table) {
            $table->id();
            $table->string('_fescal_year')->nullable();
            $table->double('_sloat_min',15,4)->default(0);
            $table->double('_sloat_max',15,4)->default(0);
            $table->double('_ta_rate',15,4)->default(0);
            $table->double('_fixed_amount',15,4)->default(0);
            $table->tinyInteger('_type')->default(0);
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
        Schema::dropIfExists('ta_da_setups');
    }
}
