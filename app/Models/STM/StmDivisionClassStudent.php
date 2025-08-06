<?php

namespace App\Models\STM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmDivisionClassStudent extends Model
{
    use HasFactory;


public function division()
{
    return $this->belongsTo(StmDivision::class, '_division_id');
}

public function class()
{
    return $this->belongsTo(StmClass::class, '_class_id'); // use actual model name
}


    public function _division(){
        return $this->hasOne(StmDivision::class,'id','_division_id');
    }



    public function _class_info(){
        return $this->hasOne(StmClass::class,'id','_class_id');
    }

    
    public function _session_info(){
        return $this->hasOne(StmDivision::class,'id','_session');
    }

    public function _student(){
        return $this->hasOne(StmStudent::class,'id','_student_id')->select('id','_admission_session_id', '_education_type', '_admission_class_id', '_current_class_id', '_student_id', '_proximity_card_no', '_name_in_english', '_name_in_bangla','_gender', '_email', '_date_of_birth','_father_name_bangla', '_father_name_english','_roll_no','_f_mobile_no');
    }


}
