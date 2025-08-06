<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_employees', function (Blueprint $table) {
            $table->id();
            $table->string('_code')->nullable()->comment('Manual Code or Auto generated code department Wise');
            $table->string('_photo')->nullable();
            $table->string('_name')->nullable();
            $table->string('_father')->nullable();
            $table->string('_mother')->nullable();
            $table->string('_spouse')->nullable();
            $table->string('_mobile1')->nullable();
            $table->string('_mobile2')->nullable();
            $table->string('_spousesmobile')->nullable();
            $table->string('_nid')->nullable();
            $table->string('_gender')->nullable();
            $table->string('_bloodgroup')->nullable();
            $table->string('_religion')->nullable();
            $table->string('_dob')->nullable();
            $table->string('_education')->nullable();
            $table->string('_email')->nullable();
            $table->integer('_jobtitle_id')->nullable();
            $table->integer('_department_id')->nullable();
            $table->integer('_grade_id')->nullable();
            $table->string('_location')->nullable();
            $table->string('_officedes')->nullable();
            $table->string('_bank')->nullable();
            $table->string('_bankac')->nullable();
            $table->integer('_tradeing_id')->nullable();
            $table->integer('_project_id')->nullable();
            $table->integer('_costcenter_id')->nullable();
            $table->integer('_brach_id')->nullable();
            $table->integer('_profitcenter_id')->nullable();
            $table->integer('_active')->default(1);
            $table->date('_doj')->nullable();
            $table->string('_tin')->nullable();

            $table->integer('_user')->nullable();
            $table->integer('_employee_id');
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
        Schema::dropIfExists('hrm_employees');
    }
}
