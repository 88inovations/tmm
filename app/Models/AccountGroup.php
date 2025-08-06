<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AccountGroup extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];


    public function account_type(){
        return $this->hasOne(AccountHead::class,'id','_account_head_id');
    }

    public function _group_wise_ledger(){
        return $this->hasMany(AccountLedger::class,'_account_group_id','id');
    }

    
}
