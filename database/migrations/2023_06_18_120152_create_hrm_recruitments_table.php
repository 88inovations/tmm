<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmRecruitmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_recruitments', function (Blueprint $table) {
           $table->id();;
            $table->string('_name')->nullable();
            $table->string('_contactno')->nullable();
            $table->string('_email')->nullable();
            $table->integer('_vacancy')->default(0);
            $table->longText('_resume')->nullable();
            $table->longText('_comment')->nullable();
            $table->date('_date')->nullable();
            $table->string('_qualification')->nullable();
            $table->string('_experience')->nullable();
            $table->double('_salary',15,4)->default(0);
            $table->tinyInteger('_selected')->default(0);
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
        Schema::dropIfExists('hrm_recruitments');
    }
}
