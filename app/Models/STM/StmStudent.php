<?php

namespace App\Models\STM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmStudent extends Model
{
    use HasFactory;

    protected $table="stm_students";

    protected $fillable=['id', '_user_table_id', 'organization_id', '_branch_id', '_account_group_id', '_ledger_id', '_roll_no', '_admission_date', '_admission_session_id', '_education_type', '_admission_class_id', '_current_class_id', '_student_id', '_proximity_card_no', '_name_in_english', '_name_in_bangla', '_religion', '_student_image', '_gender', '_email', '_date_of_birth', '_barth_id', '_bloodgroup', '_s_identification_mark', '_age', '_nationality', '_height', '_weight', '_father_name_bangla', '_father_name_english', '_occupation', '_annual_income', '_f_mobile_no', '_f_nid_no', '_f_email', '_mother_name_english', '_mother_name_of_bangla', '_mother_occupation', '_mother_mobile_no', '_mother_anual_income', '_mother_nid_no', '_mother_email', '_local_guardian_name', '_local_guardian_occupation', '_local_guardian_address', '_local_guardian_mobile', '_local_guardian_nid', '_local_guardian_nid_image', '_present_address', '_per_country_id', '_per_division_id', '_per_district_id', '_per_thana_id', '_per_union_id', '_cur_division_id', '_cur_country_id', '_cur_district_id', '_cur_thana_id', '_cur_union_id', '_per_post_office', '_cur_post_office', '_parmanent_address', '_previous_institute_name', '_pre_class', '_pre_result', '_pre_roll_no', '_father_nid_image', '_mother_nid_image', '_birth_certificate', '_transfer_certificate', '_testimonial', '_academic_certificate', '_marksheet', '_student_photo', '_adminssion_fee_amount', '_monthly_fee', '_resedential_type', '_parents_signature', '_main_subjects', '_optional_subjects', '_detail', '_user_id', '_user_name', '_status', '_lock', '_created_by', '_updated_by', 'created_at', 'updated_at'];






    public function _division_class_student(){
        return $this->hasMany(StmDivisionClassStudent::class,'_student_id','id')->where('_status',1);
    }

    public function _edu_class(){
        return $this->hasOne(StmClass::class,'id','_admission_class_id');
    }




    public function _edu_division(){
        return $this->hasOne(StmDivision::class,'id','_education_type');
    }


    public function _edu_session(){
        return $this->hasOne(StmEducationSession::class,'id','_admission_session_id');
    }

    public function _per_division(){
        return $this->hasOne(\App\Models\Division::class,'id','_per_division_id');
    }
    public function _cur_division(){
        return $this->hasOne(\App\Models\Division::class,'id','_cur_division_id');
    }
    public function _per_district(){
        return $this->hasOne(\App\Models\District::class,'id','_per_district_id');
    }
    public function _cur_district(){
        return $this->hasOne(\App\Models\District::class,'id','_cur_district_id');
    }

    public function _per_thana(){
        return $this->hasOne(\App\Models\Upazila::class,'id','_per_thana_id');
    }
    public function _cur_thana(){
        return $this->hasOne(\App\Models\Upazila::class,'id','_cur_thana_id');
    }


    public function _per_union(){
        return $this->hasOne(\App\Models\Postcode::class,'id','_per_union_id');
    }
    public function _cur_union(){
        return $this->hasOne(\App\Models\Postcode::class,'id','_cur_union_id');
    }
    public function _per_country(){
        return $this->hasOne(\App\Models\Country::class,'id','_per_country_id');
    }
    public function _cur_country(){
        return $this->hasOne(\App\Models\Country::class,'id','_cur_country_id');
    }











}



