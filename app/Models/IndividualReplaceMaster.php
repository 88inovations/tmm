<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class IndividualReplaceMaster extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


     public function _master_branch(){
    	return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    

    public function _customer_ledger(){
    	return $this->hasOne(AccountLedger::class,'id','_customer_id')->select('id','_name','_account_group_id','_account_head_id','_address','_phone','_email')
        ->with(['account_type','account_group']);
    }

    public function _supplier_ledger(){
    	return $this->hasOne(AccountLedger::class,'id','_supplier_id')->select('id','_name','_account_group_id','_account_head_id','_address','_phone','_email')
        ->with(['account_type','account_group']);
    }
    public function _warranty_detail(){
        return $this->hasOne(WarrantyMaster::class,'id','_order_ref_id');;
    }


    public function _ind_repl_old_item(){
    	return $this->hasOne(IndividualReplaceOldItem::class,'_no','id')->with(['_detail_branch','_detail_cost_center','_items'])->where('_status',1);
    }

    public function _ind_repl_in_item(){
    	return $this->hasOne(IndividualReplaceInItem::class,'_no','id')->with(['_detail_branch','_detail_cost_center','_items'])->where('_status',1);
    }

    public function _ind_repl_out_item(){
    	return $this->hasOne(IndividualReplaceOutItem::class,'_no','id')->with(['_detail_branch','_detail_cost_center','_items'])->where('_status',1);
    }

    
public function _ind_repl_in_account(){
    	return $this->hasMany(IndividualReplaceInAccount::class,'_no','id')->with(['_ledger','_detail_branch','_detail_cost_center'])->where('_status',1);


    }

    public function _ind_repl_out_acount(){
    	return $this->hasMany(IndividualReplaceOutAccount::class,'_no','id')->with(['_detail_branch','_detail_cost_center'])->where('_status',1);
    }

}
