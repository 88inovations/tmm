<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPayment extends Model
{
    use HasFactory;


    public function _master_branch(){
        return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function _master_details(){
        return $this->hasMany(SupplierPaymentDetail::class,'_no','id')->with(['_receive_ledger'])->where('_status',1);
    }

    public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id')->select('id','_name');
    }


public function _sup_cus(){
    return $this->hasOne(\App\Models\AccountLedger::class,'id','_ledger_id');
}
    


    public function _voucher_emp_ref(){
        return $this->hasOne(AccountLedger::class,'id','_sales_man_id')->select('id','_name','_address','_phone','_account_group_id','_account_head_id');
    }
}
