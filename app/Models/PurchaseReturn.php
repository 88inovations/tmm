<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class PurchaseReturn extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];
    protected $table="purchase_returns";
    

     public function _master_branch(){
    	return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function _master_details(){
    	return $this->hasMany(PurchaseReturnDetail::class,'_no','id')->with(['_detail_branch','_detail_cost_center','_store','_items','unit_conversion','_trans_unit','_units','_product_price_item'])->where('_status',1);

        



    }

    public function purchase_account(){
    	return $this->hasMany(PurchaseReturnAccount::class,'_no','id')->with(['_ledger','_detail_branch','_detail_cost_center'])->where('_status',1);


    }

    public function _ledger(){
    	return $this->hasOne(AccountLedger::class,'id','_ledger_id');
    }

    public function _master_cost_center(){
        return $this->hasOne(CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }

    public function _master_store(){
        return $this->hasOne(StoreHouse::class,'id','_store_id')->select('id','_name');
    }
}
