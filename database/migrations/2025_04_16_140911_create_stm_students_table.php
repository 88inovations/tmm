<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStmStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stm_students', function (Blueprint $table) {
            $table->id();
            $table->integer('_user_table_id')->default(0);
            $table->integer('_ledger_id')->default(0);
            $table->date('_admission_date');
            $table->integer('_education_type')->nullable();
            $table->integer('_admission_class_id')->nullable();
            $table->integer('_current_class_id')->nullable();
            $table->string('_student_id')->nullable();
            $table->string('_proximity_card_no')->nullable();
            $table->string('_name_in_english')->nullable();
            $table->string('_name_in_bangla')->nullable();
            $table->string('_student_image')->nullable();
            $table->string('_gender')->nullable();
            $table->string('_email')->nullable();
            $table->date('_date_of_birth')->nullable();
            $table->string('_barth_id')->nullable();
            $table->string('_bloodgroup')->nullable();
            $table->string('_s_identification_mark')->nullable();
            $table->string('_age')->nullable();
            $table->string('_nationality')->nullable();
            $table->string('_height')->nullable();
            $table->string('_weight')->nullable();
            $table->string('_father_name_bangla')->nullable();
            $table->string('_father_name_english')->nullable();
            $table->string('_occupation')->nullable();
            $table->string('_annual_income')->nullable();
            $table->string('_f_mobile_no')->nullable();
            $table->string('_f_nid_no')->nullable();
            $table->string('_f_email')->nullable();
            $table->string('_mother_name_english')->nullable();
            $table->string('_mother_name_of_bangla')->nullable();
            $table->string('_mother_occupation')->nullable();
            $table->string('_mother_anual_income')->nullable();
            $table->string('_mother_nid_no')->nullable();
            $table->string('_mother_email')->nullable();
            $table->string('_local_guardian_name')->nullable();
            $table->string('_local_guardian_address')->nullable();
            $table->string('_local_guardian_mobile')->nullable();
            $table->string('_local_guardian_nid')->nullable();
            $table->string('_local_guardian_nid_image')->nullable();
            $table->text('_present_address')->nullable();

            $table->integer('_country_id')->nullable();
            $table->integer('_per_division_id')->nullable();
            $table->integer('_per_district_id')->nullable();
            $table->integer('_per_thana_id')->nullable();
            $table->integer('_per_union_id')->nullable();

            $table->integer('_cur_division_id')->nullable();
            $table->integer('_cur_district_id')->nullable();
            $table->integer('_cur_thana_id')->nullable();
            $table->integer('_cur_union_id')->nullable();

            $table->text('_parmanent_address')->nullable();
            $table->string('_previous_institute_name')->nullable();
            $table->string('_pre_class')->nullable();
            $table->string('_pre_result')->nullable();
            $table->string('_pre_roll_no')->nullable();
            $table->string('_father_nid_image')->nullable();
            $table->string('_mother_nid_image')->nullable();

            $table->string('_birth_certificate')->nullable();
            $table->string('_transfer_certificate')->nullable();
            $table->string('_academic_certificate')->nullable();
            $table->string('_testimonial')->nullable();
            $table->string('_marksheet')->nullable();
            $table->string('_student_photo')->nullable();

            $table->double('_adminssion_fee_amount',15,4)->default(0);
            $table->double('_monthly_fee',15,4)->default(0);
            $table->string('_resedential_type')->nullable();
            $table->string('_parents_signature')->nullable();
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
        Schema::dropIfExists('stm_students');
    }
}
