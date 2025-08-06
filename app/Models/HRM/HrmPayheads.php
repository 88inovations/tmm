<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AccountLedger;
use App\Models\User;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class HrmPayheads extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

   protected $table="hrm_payheads";
   protected $fillable=['id', '_ledger', '_type', '_calculation', '_onhead', '_user', '_status', 'created_at', 'updated_at'];

   

    public function _entry_by(){
    	return $this->hasOne(User::class,'id','_user')->select('id','name','email');
    }

    public function _payhead_type(){
        return $this->hasOne(HrmPayHeadType::class,'id','_type');
    }

    public function _ledger_info(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_ledger_id');
    }
}
