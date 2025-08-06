<?php

namespace App\Models\RLP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RlpDetail extends Model
{
    use HasFactory;

    public function _items(){
        return $this->hasOne(\App\Models\Inventory::class,'id','_item_id')->with(['_units']);
    }

    public function _supplier(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_ledger_id')->select('id','_name','_phone','_address','_code');
    }
}
