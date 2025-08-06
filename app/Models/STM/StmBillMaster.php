<?php

namespace App\Models\STM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmBillMaster extends Model
{
    use HasFactory;




    public function _detail(){
        return $this->hasMany(StmBillMasterDetail::class,'_no','id')->with(['_student'])->where('_status',1);
    }


     public function _branch(){
        return $this->hasOne(\App\Models\Branch::class,'id','_branch_id')->select('id','_name');
    }
    
    public function _ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_dr_ledger_id')->select('id','_name','_account_group_id','_account_head_id','_address','_phone','_email','_alious');
    }

    public function _cost_center(){
        return $this->hasOne(\App\Models\CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }
    public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }

      public function _edu_class(){
        return $this->hasOne(StmClass::class,'id','_class_id');
    }




    public function _edu_division(){
        return $this->hasOne(StmDivision::class,'id','_stm_division_id');
    }


    public function _edu_session(){
        return $this->hasOne(StmEducationSession::class,'id','_session_id');
    }

  
}
