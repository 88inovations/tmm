<?php

namespace App\Models\HON;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HonorimSetup extends Model
{
    use HasFactory;


    public function _branch(){
        return $this->hasOne(\App\Models\Branch::class,'id','_branch_id')->select('id','_name');
    }
    public function _ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_ledger_id');
    }
   public function _cost_center(){
        return $this->hasOne(\App\Models\CostCenter::class,'id','_cost_center_id');
    }
   public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id');
    }
}
