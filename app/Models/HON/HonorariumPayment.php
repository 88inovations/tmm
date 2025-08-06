<?php

namespace App\Models\HON;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HonorariumPayment extends Model
{
    use HasFactory;

    public function _branch(){
        return $this->hasOne(\App\Models\Branch::class,'id','_branch_id')->select('id','_name');
    }
    
   
   public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id');
    }


   public function _cost_center(){
        return $this->hasOne(\App\Models\CostCenter::class,'id','_cost_center_id');
    }

    public function _ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_honorarium_ledger_id')->with(['_branch']);
    }


    public function _voucher_detail(){
        return $this->hasMany(\App\Models\VoucherMaster::class,'_transection_ref','id')->where('_transection_type','honorarium_payments')->with(['_master_details']);
    }

    public function _details(){
        return $this->hasMany(\App\Models\HON\HonorariumPaymentDetail::class,'_no','id')->with(['_cash_ledger','_honorarium_bill'])->where('_status',1);
    }
}
