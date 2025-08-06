<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class MusakFourPointThreeAddition extends Model implements Auditable{
    use HasFactory;
    use AuditableTrait;
    protected $guarded = [];

    public function _addition_ledger(){
        return $this->hasOne(AccountLedger::class,'id','_ledger_id')->select('id','_account_group_id','_account_head_id','_name','_balance');
    } 
}
