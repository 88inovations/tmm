<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class DamageAdjustment extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


    public function _master_branch(){
    	return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function _master_details(){
    	return $this->hasMany(DamageAdjustmentDetail::class,'_no','id')->with(['_detail_branch','_detail_cost_center','_store','_items','_units','_trans_unit','unit_conversion'])->where('_status',1);
    }
	public function _ledger(){
	    	return $this->hasOne(AccountLedger::class,'id','_ledger_id');
	}

    public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }
}
