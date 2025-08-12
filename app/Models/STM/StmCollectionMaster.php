<?php

namespace App\Models\STM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmCollectionMaster extends Model
{
    use HasFactory;

    protected $table="stm_collection_masters";

    protected $fillable=['id', '_date', '_roshid_book_no', '_roshid_no', 'organization_id', '_branch_id', '_cost_center_id', '_order_number', '_bill_type', '_month_id', '_year', '_stm_division_id', '_session_id', '_class_id', '_student_table_id', '_voucher_id', '_voucher_code', '_dr_ledger_id', '_cr_ledger_id', '_number_of_student', '_total_amount', '_discount_amount', '_net_amount', '_note', '_user_id', '_user_name', '_status', '_lock', '_created_by', '_updated_by', 'created_at', 'updated_at'  ];





public function _detail(){
        return $this->hasMany(StmBillCollection::class,'_no','id')->with(['_student'])->where('_status',1);
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
        return $this->hasOne(StmEducationSession::class,'id','_admission_session_id');
    }

    public function _student(){
        return $this->hasOne(StmStudent::class,'id','_student_table_id');
    }
}


 