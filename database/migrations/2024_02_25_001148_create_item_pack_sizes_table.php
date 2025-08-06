<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPackSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_pack_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('_name');
            $table->string('_code')->nullable();
            $table->text('_detail')->nullable();
            $table->tinyInteger('_status')->default(0);
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
        Schema::dropIfExists('item_pack_sizes');
    }
}
