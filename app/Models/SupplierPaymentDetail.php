<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPaymentDetail extends Model
{
    use HasFactory;


    public function _receive_ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_collection_ledger_id');
    }
}
