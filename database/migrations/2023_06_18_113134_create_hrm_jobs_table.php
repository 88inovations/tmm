<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('_jobtitle_id')->nullable();
            $table->integer('_job_id')->nullable();
            $table->text('_specification')->nullable();
            $table->string('_jtype')->nullable();
            $table->string('_status')->nullable();
            $table->string('_location')->nullable();
            $table->string('_responsibility')->nullable();
            $table->date('_joindate')->nullable();
            $table->double('_salary',15,4)->nullable();
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
        Schema::dropIfExists('hrm_jobs');
    }
}
