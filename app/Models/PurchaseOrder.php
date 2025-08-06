<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PurchaseOrder extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];
    
     public function _master_branch(){
    	return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name','_address','_phone');
    }

    public function _master_details(){
    	return $this->hasMany(PurchaseOrderDetail::class,'_no','id')->with(['_detail_branch','_detail_cost_center','_store','_items','_trans_unit'])->where('_status',1);
    }
    public function purchase_order_account(){
        return $this->hasMany(PurchaseOrderAccount::class,'_no','id')->with(['_ledger','_detail_branch','_detail_cost_center'])->where('_status',1);


    }

    public function _ledger(){
        return $this->hasOne(AccountLedger::class,'id','_ledger_id')->select('id','_name','_account_group_id','_account_head_id')
        ->with(['account_type','account_group']);
    }



    public function _master_cost_center(){
        return $this->hasOne(CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }
    public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }

    public function _master_store(){
        return $this->hasOne(StoreHouse::class,'id','_store_id')->select('id','_name');
    }


}
