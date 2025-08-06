<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class WarrantyMaster extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

     public function _master_branch(){
    	return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function _master_details(){
    	return $this->hasMany(WarrantyDetail::class,'_no','id')->with(['_detail_branch','_detail_cost_center','_store','_items','_warrant'])->where('_status',1);
    }

    public function s_account(){
    	return $this->hasMany(WarrantyAccount::class,'_no','id')->with(['_ledger','_detail_branch','_detail_cost_center'])->where('_status',1);


    }

    public function _ledger(){
    	return $this->hasOne(AccountLedger::class,'id','_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance');
    }

    public function sales_info(){
        return $this->hasOne(Sales::class,'id','_order_ref_id')->with(['_ledger']);
    }
}
