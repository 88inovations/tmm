<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceFromSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_from_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('_default_service_income');
            $table->integer('_default_discount');
            $table->integer('_default_vat_account');
             $table->integer('_show_inline_note');
             $table->integer('_show_service_name');
             $table->integer('_show_vat');
             $table->integer('_inline_discount');
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
        Schema::dropIfExists('service_from_settings');
    }
}
