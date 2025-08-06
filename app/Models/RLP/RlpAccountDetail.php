<?php

namespace App\Models\RLP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RlpAccountDetail extends Model
{
    use HasFactory;

    public function _ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_rlp_ledger_id');
    }
}
