<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class VoucherMaster extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


    public function _master_branch(){
    	return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function _master_details(){
    	return $this->hasMany(VoucherMasterDetail::class,'_no','id')->with(['_voucher_ledger','_detail_branch','_detail_cost_center'])->where('_status',1);
    }

    public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }


    public function check_info(){
        return $this->hasOne(VoucharCheckInfo::class,'_voucher_no','id')->where('_status',1)->where('_is_delete',0);
    }


    public function _voucher_emp_ref(){
        return $this->hasOne(AccountLedger::class,'id','_sales_man_id')->select('id','_name','_address','_phone','_account_group_id','_account_head_id');
    }

    
}
