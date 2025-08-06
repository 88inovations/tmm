<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class SalesWithoutLot extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];
    protected $table="sales_without_lots";



    public function _master_details(){
        return $this->hasMany(SalesWithoutLotDetails::class,'_no','id')->with(['_detail_branch','_detail_cost_center','_store','_items','_warrant','_units','_trans_unit','unit_conversion'])->where('_status',1);
    }

    public function _sales_detail_item(){
        return $this->hasMany(SalesWithoutLotDetails::class,'_no','id')->where('_status',1);
    }


    public function _sales_return_wlm(){
        return $this->hasMany(SalesReturnWlm::class,'sales_invoice_no','_order_number');
    }


    public function _bill_send_detail(){
        return $this->hasOne(BillSendDetail::class,'_sales_id','_order_number')->select('id','_sales_id');
    }





    public function s_account(){
        return $this->hasMany(SalesWithoutLotAccount::class,'_no','id')->with(['_ledger','_detail_branch','_detail_cost_center'])->where('_status',1);


    }

    public function _ledger(){
        return $this->hasOne(AccountLedger::class,'id','_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance','_alious','_code','_phone','_address');
    }
    public function _delivery_man(){
        return $this->hasOne(AccountLedger::class,'id','_delivery_man_id')->select('id','_account_group_id','_account_head_id','_name','_balance');
    } 
    public function _sales_man(){
        return $this->hasOne(AccountLedger::class,'id','_sales_man_id')->select('id','_account_group_id','_account_head_id','_name','_balance');
    }

    public function _master_cost_center(){
        return $this->hasOne(CostCenter::class,'id','_cost_center_id')->select('id','_name');
    }
   public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }
    public function _master_branch(){
        return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

   

    public function _master_store(){
        return $this->hasOne(StoreHouse::class,'id','_store_id')->select('id','_name');
    }

    public function _terms_con(){
        return $this->hasOne(TransectionTerms::class,'id','_payment_terms')->select('id','_name','_detail','_days');
    }

    public function _sales_return(){
        return $this->hasMany(SalesReturnWlm::class,'_order_ref_id','id')->with(['_master_details']);
    }
}
