<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AccountLedger extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    protected $table = 'account_ledgers';

    
    public function account_type(){
    	return $this->hasOne(AccountHead::class,'id','_account_head_id')->select('id','_name');
    }


    public function account_group(){
    	return $this->hasOne(AccountGroup::class,'id','_account_group_id')->select('id','_name');
    }


    public function last_balance(){
    	return $this->hasOne(Accounts::class,'_account_ledger','id');
    }

    public function _entry_branch(){
        return $this->hasOne(Branch::class,'id','_branch_id')->select('id','_name');
    }

    public function _branch(){
        return $this->hasOne(\App\Models\Branch::class,'id','_branch_id')->select('id','_name');
    }
    
   
   public function _organization(){
        return $this->hasOne(\App\Models\HRM\Company::class,'id','organization_id');
    }


   public function _cost_center(){
        return $this->hasOne(\App\Models\CostCenter::class,'id','_cost_center_id');
    }



    public function _honorarium_info(){
        return $this->hasOne(\App\Models\HON\HonorimSetup::class,'_ledger_id','id');
    }


}
