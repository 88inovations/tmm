<?php

namespace App\Models\STM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmBillMasterDetail extends Model
{
    use HasFactory;

      public function _student(){
        return $this->hasOne(StmStudent::class,'id','_student_id')->select('id','_admission_session_id', '_education_type', '_admission_class_id', '_current_class_id', '_student_id', '_proximity_card_no', '_name_in_english', '_name_in_bangla','_gender', '_email', '_date_of_birth','_father_name_bangla', '_father_name_english','_roll_no');
    }


    public function _division(){
        return $this->hasOne(StmDivision::class,'id','_stm_division_id');
    }



    public function _class_info(){
        return $this->hasOne(StmDivision::class,'id','_class_id');
    }

    
    public function _session_info(){
        return $this->hasOne(StmDivision::class,'id','_session_id');
    }


    public function _collect_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_collection_ledger_id');
    }


    public function _master(){
        return $this->hasOne(StmBillMaster::class,'id','_no');
    }

}
