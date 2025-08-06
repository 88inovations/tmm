<?php

namespace App\Models\AssetManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportCostAccount extends Model
{
    use HasFactory;


    public function _ledger(){
        return $this->hasOne(\App\Models\AccountLedger::class,'id','_ledger_id');
    }
}
